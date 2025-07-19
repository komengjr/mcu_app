<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Medical Check Up | Management System</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/dashboard.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/dashboard.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/dashboard.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/dashboard.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    {{-- <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script> --}}


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> --}}

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{-- <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script> --}}
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    {{-- <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script> --}}
</head>
<style>
    /* .kbw-signature {
        width: 100%;
        height: 200px;
    } */
    canvas {
        background-color: #000;
        display: block;
        margin: 0 auto;
        /* width: 100%; */
        height: 200px;
    }
</style>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-100 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape"
                        src="../../../asset/img/icons/spot-illustrations/bg-shape.png" alt=""
                        width="250"><img class="bg-auth-circle-shape-2"
                        src="../../../asset/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-gradient bg-danger ">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <div class="bg-holder bg-auth-card-shape"
                                            style="background-image:url(../../../asset/img/icons/spot-illustrations/half-circle.png);">
                                        </div>
                                        <!--/.bg-holder-->

                                        <div class="z-index-1 position-relative">
                                            <a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder"
                                                href="#"><img src="{{ asset('img/pram.png') }}"
                                                    alt=""></a>
                                            <p class="opacity-75 text-white">With the power of Falcon, you can now focus
                                                only on functionaries for your digital products, while leaving the UI
                                                design on us!</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-3 flex-grow-1">
                                        <h3>Peserta MCU</h3>
                                        <form method="POST" action="{{ route('signaturepad.update') }}">
                                            @csrf
                                            <input type="text" name="token"
                                                value="{{ $data->log_kehadiran_pasien_token }}" hidden>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-name">Nama Lengkap</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        id="card-name" value="{{ $data->mou_peserta_name }}"
                                                        disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Nomor Induk
                                                        Pegawai</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        id="card-email" value="{{ $data->mou_peserta_nip }}"
                                                        disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Nomor Whatsapp</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        value="{{ $data->mou_peserta_no_hp }}" disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="card-email">Email</label>
                                                    <input class="form-control" type="text" autocomplete="on"
                                                        value="{{ $data->mou_peserta_email }}" disabled />
                                                </div>
                                                <div class="position-relative mt-2">
                                                    <hr class="bg-300" />
                                                    <div class="divider-content-center">Sign Here</div>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="#" id="clear"
                                                        class="text-danger float-end">Clear Signature</a>
                                                    <span id="sig"></canvas>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="card-register-checkbox" />
                                                        <label class="form-label" for="card-register-checkbox">I
                                                            accept
                                                            the <a href="#!">terms </a>and <a
                                                                href="#!">privacy
                                                                policy</a></label>
                                                    </div>
                                                </div>
                                                <textarea id="signature64" name="signed"></textarea>
                                                <input type="text" name="cabang"
                                                    value="{{ $data->log_kehadiran_pasien_lokasi }}" hidden>
                                                <input type="text" name="peserta"
                                                    value="{{ $data->mou_peserta_code }}" hidden>

                                                <div class="col-md-12">
                                                    <button class="btn btn-danger w-100 " id="button-submit-selesai"
                                                        type="submit" name="submit">Register</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- <a href="#" onclick="myFunction()">Selsai</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    {{-- <script src="{{ asset('vendors/popper/popper.min.js') }}"></script> --}}
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script>
        /*! http://keith-wood.name/signature.html
    	Signature plugin for jQuery UI v1.2.1.
    	Requires excanvas.js in IE.
    	Written by Keith Wood (wood.keith{at}optusnet.com.au) April 2012.
    	Available under the MIT (http://keith-wood.name/licence.html) license.
    	Please attribute the author if you use it. */

        /* globals G_vmlCanvasManager */

        (function($) { // Hide scope, no $ conflict
            'use strict';

            /** Signature capture and display.
    		<p>Depends on <code>jquery.ui.widget</code>, <code>jquery.ui.mouse</code>.</p>
    		<p>Expects HTML like:</p>
    		<pre>&lt;div>&lt;/div></pre>
    		@namespace Signature
    		@augments $.Widget
    		@example $(selector).signature()
    $(selector).signature({color: 'blue', guideline: true}) */
            var signatureOverrides = {

                /** Be notified when a signature changes.
    			@callback SignatureChange
    			@global
    			@this Signature
    			@example change: function() {
      console.log('Signature changed');
    } */

                /** Global defaults for signature.
                	@memberof Signature
                	@property {number} [distance=0] The minimum distance to start a drag.
                	@property {string} [background='#fff'] The background colour.
                	@property {string} [color='#000'] The colour of the signature.
                	@property {number} [thickness=2] The thickness of the lines.
                	@property {boolean} [guideline=false] <code>true</code> to add a guideline.
                	@property {string} [guidelineColor='#a0a0a0'] The guideline colour.
                	@property {number} [guidelineOffset=50] The guideline offset (pixels) from the bottom.
                	@property {number} [guidelineIndex=10] The guideline indent (pixels) from the edges.
                	@property {string} [notAvailable='Your browser doesn\'t support signing']
                						The error message to show when no canvas is available.
                	@property {number} [scale=1] A scaling factor for rendering the signature (only applies to redraws).
                	@property {string|Element|jQuery} [syncField=null] The selector, DOM element, or jQuery object
                						for a field to automatically synchronise with a text version of the signature.
                	@property {string} [syncFormat='JSON'] The output representation: 'JSON', 'SVG', 'PNG', 'JPEG'.
                	@property {boolean} [svgStyles=false] <code>true</code> to use the <code>style</code> attribute in SVG.
                	@property {SignatureChange} [change=null] A callback triggered when the signature changes.
                	@example $.extend($.kbw.signature.options, {guideline: true}) */
                options: {
                    distance: 0,
                    background: '#fff',
                    color: '#000',
                    thickness: 2,
                    guideline: false,
                    guidelineColor: '#a0a0a0',
                    guidelineOffset: 50,
                    guidelineIndent: 10,
                    notAvailable: 'Your browser doesn\'t support signing',
                    scale: 1,
                    syncField: null,
                    syncFormat: 'JSON',
                    svgStyles: false,
                    change: null
                },

                /** Initialise a new signature area.
                	@memberof Signature
                	@private */
                _create: function() {
                    this.element.addClass(this.widgetFullName || this.widgetBaseClass);
                    try {
                        this.canvas = $('<canvas width="' + this.element.width() + '" height="' +
                            this.element.height() + '">' + this.options.notAvailable + '</canvas>')[0];
                        this.element.append(this.canvas);
                    } catch (e) {
                        $(this.canvas).remove();
                        this.resize = true;
                        this.canvas = document.createElement('canvas');
                        this.canvas.setAttribute('width', this.element.width());
                        this.canvas.setAttribute('height', this.element.height());
                        this.canvas.innerHTML = this.options.notAvailable;
                        this.element.append(this.canvas);
                        /* jshint -W106 */
                        if (G_vmlCanvasManager) { // Requires excanvas.js
                            G_vmlCanvasManager.initElement(this.canvas);
                        }
                        /* jshint +W106 */
                    }
                    this.ctx = this.canvas.getContext('2d');
                    this._refresh(true);
                    this._mouseInit();
                },

                /** Refresh the appearance of the signature area.
                	@memberof Signature
                	@private
                	@param {boolean} init <code>true</code> if initialising. */
                _refresh: function(init) {
                    if (this.resize) {
                        var parent = $(this.canvas);
                        $('div', this.canvas).css({
                            width: parent.width(),
                            height: parent.height()
                        });
                    }
                    this.ctx.fillStyle = this.options.background;
                    this.ctx.strokeStyle = this.options.color;
                    this.ctx.lineWidth = this.options.thickness;
                    this.ctx.lineCap = 'round';
                    this.ctx.lineJoin = 'round';
                    this.clear(init);
                },

                /** Clear the signature area.
                	@memberof Signature
                	@param {boolean} init <code>true</code> if initialising - internal use only.
                	@example $(selector).signature('clear') */
                clear: function(init) {
                    if (this.options.disabled) {
                        return;
                    }
                    this.ctx.clearRect(0, 0, this.element.width(), this.element.height());
                    this.ctx.fillRect(0, 0, this.element.width(), this.element.height());
                    if (this.options.guideline) {
                        this.ctx.save();
                        this.ctx.strokeStyle = this.options.guidelineColor;
                        this.ctx.lineWidth = 1;
                        this.ctx.beginPath();
                        this.ctx.moveTo(this.options.guidelineIndent,
                            this.element.height() - this.options.guidelineOffset);
                        this.ctx.lineTo(this.element.width() - this.options.guidelineIndent,
                            this.element.height() - this.options.guidelineOffset);
                        this.ctx.stroke();
                        this.ctx.restore();
                    }
                    this.lines = [];
                    if (!init) {
                        this._changed();
                    }
                },

                /** Synchronise changes and trigger a change event.
                	@memberof Signature
                	@private
                	@param {Event} event The triggering event. */
                _changed: function(event) {
                    if (this.options.syncField) {
                        var output = '';
                        switch (this.options.syncFormat) {
                            case 'PNG':
                                output = this.toDataURL();
                                break;
                            case 'JPEG':
                                output = this.toDataURL('image/jpeg');
                                break;
                            case 'SVG':
                                output = this.toSVG();
                                break;
                            default:
                                output = this.toJSON();
                        }
                        $(this.options.syncField).val(output);
                    }
                    this._trigger('change', event, {});
                },

                /** Refresh the signature when options change.
                	@memberof Signature
                	@private
                	@param {object} options The new option values. */
                _setOptions: function( /* options */ ) {
                    if (this._superApply) {
                        this._superApply(arguments); // Base widget handling
                    } else {
                        $.Widget.prototype._setOptions.apply(this, arguments); // Base widget handling
                    }
                    var count = 0;
                    var onlyDisable = true;
                    for (var name in arguments[0]) {
                        if (arguments[0].hasOwnProperty(name)) {
                            count++;
                            onlyDisable = onlyDisable && name === 'disabled';
                        }
                    }
                    if (count > 1 || !onlyDisable) {
                        this._refresh();
                    }
                },

                /** Determine if dragging can start.
                	@memberof Signature
                	@private
                	@param {Event} event The triggering mouse event.
                	@return {boolean} <code>true</code> if allowed, <code>false</code> if not */
                _mouseCapture: function( /* event */ ) {
                    return this.options.disabled;
                },

                /** Start a new line.
                	@memberof Signature
                	@private
                	@param {Event} event The triggering mouse event. */
                _mouseStart: function(event) {
                    this.offset = this.element.offset();
                    this.offset.left -= document.documentElement.scrollLeft || document.body.scrollLeft;
                    this.offset.top -= document.documentElement.scrollTop || document.body.scrollTop;
                    this.lastPoint = [this._round(event.clientX - this.offset.left),
                        this._round(event.clientY - this.offset.top)
                    ];
                    this.curLine = [this.lastPoint];
                    this.lines.push(this.curLine);
                },

                /** Track the mouse.
                	@memberof Signature
                	@private
                	@param {Event} event The triggering mouse event. */
                _mouseDrag: function(event) {
                    var point = [this._round(event.clientX - this.offset.left),
                        this._round(event.clientY - this.offset.top)
                    ];
                    this.curLine.push(point);
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastPoint[0], this.lastPoint[1]);
                    this.ctx.lineTo(point[0], point[1]);
                    this.ctx.stroke();
                    this.lastPoint = point;
                },

                /** End a line.
                	@memberof Signature
                	@private
                	@param {Event} event The triggering mouse event. */
                _mouseStop: function(event) {
                    if (this.curLine.length === 1) {
                        event.clientY += this.options.thickness;
                        this._mouseDrag(event);
                    }
                    this.lastPoint = null;
                    this.curLine = null;
                    this._changed(event);
                },

                /** Round to two decimal points.
                	@memberof Signature
                	@private
                	@param {number} value The value to round.
                	@return {number} The rounded value. */
                _round: function(value) {
                    return Math.round(value * 100) / 100;
                },

                /** Convert the captured lines to JSON text.
                	@memberof Signature
                	@return {string} The JSON text version of the lines.
                	@example var json = $(selector).signature('toJSON') */
                toJSON: function() {
                    return '{"lines":[' + $.map(this.lines, function(line) {
                        return '[' + $.map(line, function(point) {
                            return '[' + point + ']';
                        }) + ']';
                    }) + ']}';
                },

                /** Convert the captured lines to SVG text.
                	@memberof Signature
                	@return {string} The SVG text version of the lines.
                	@example var svg = $(selector).signature('toSVG') */
                toSVG: function() {
                    var attrs1 = (this.options.svgStyles ? 'style="fill: ' + this.options.background + ';"' :
                        'fill="' + this.options.background + '"');
                    var attrs2 = (this.options.svgStyles ?
                        'style="fill: none; stroke: ' + this.options.color + '; stroke-width: ' + this
                        .options.thickness + ';"' :
                        'fill="none" stroke="' + this.options.color + '" stroke-width="' + this.options
                        .thickness + '"');
                    return '<?xml version="1.0"?>\n<!DOCTYPE svg PUBLIC ' +
                        '"-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\n' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="15cm" height="15cm">\n' +
                        '	<g ' + attrs1 + '>\n' +
                        '		<rect x="0" y="0" width="' + this.canvas.width + '" height="' + this.canvas.height +
                        '"/>\n' +
                        '		<g ' + attrs2 + '>\n' +
                        $.map(this.lines, function(line) {
                            return '			<polyline points="' +
                                $.map(line, function(point) {
                                    return point + '';
                                }).join(' ') + '"/>\n';
                        }).join('') +
                        '		</g>\n	</g>\n</svg>\n';
                },

                /** Convert the captured lines to an image encoded in a <code>data:</code> URL.
                	@memberof Signature
                	@param {string} [type='image/png'] The MIME type of the image.
                	@param {number} [quality=0.92] The image quality, between 0 and 1.
                	@return {string} The signature as a data: URL image.
                	@example var data = $(selector).signature('toDataURL', 'image/jpeg') */
                toDataURL: function(type, quality) {
                    return this.canvas.toDataURL(type, quality);
                },

                /** Draw a signature from its JSON or SVG description or <code>data:</code> URL.
                	<p>Note that drawing a <code>data:</code> URL does not reconstruct the internal representation!</p>
                	@memberof Signature
                	@param {object|string} sig An object with attribute <code>lines</code> being an array of arrays of points
                					or the text version of the JSON or SVG or a <code>data:</code> URL containing an image.
                	@example $(selector).signature('draw', sigAsJSON) */
                draw: function(sig) {
                    if (this.options.disabled) {
                        return;
                    }
                    this.clear(true);
                    if (typeof sig === 'string' && sig.indexOf('data:') === 0) { // Data URL
                        this._drawDataURL(sig, this.options.scale);
                    } else if (typeof sig === 'string' && sig.indexOf('<svg') > -1) { // SVG
                        this._drawSVG(sig, this.options.scale);
                    } else {
                        this._drawJSON(sig, this.options.scale);
                    }
                    this._changed();
                },

                /** Draw a signature from its JSON description.
                	@memberof Signature
                	@private
                	@param {object|string} sig An object with attribute <code>lines</code> being an array of arrays of points
                					or the text version of the JSON.
                	@param {number} scale A scaling factor. */
                _drawJSON: function(sig, scale) {
                    if (typeof sig === 'string') {
                        sig = $.parseJSON(sig);
                    }
                    this.lines = sig.lines || [];
                    var ctx = this.ctx;
                    $.each(this.lines, function() {
                        ctx.beginPath();
                        $.each(this, function(i) {
                            ctx[i === 0 ? 'moveTo' : 'lineTo'](this[0] * scale, this[1] *
                            scale);
                        });
                        ctx.stroke();
                    });
                },

                /** Draw a signature from its SVG description.
                	@memberof Signature
                	@private
                	@param {string} sig The text version of the SVG.
                	@param {number} scale A scaling factor. */
                _drawSVG: function(sig, scale) {
                    var lines = this.lines = [];
                    $(sig).find('polyline').each(function() {
                        var line = [];
                        $.each($(this).attr('points').split(' '), function(i, point) {
                            var xy = point.split(',');
                            line.push([parseFloat(xy[0]), parseFloat(xy[1])]);
                        });
                        lines.push(line);
                    });
                    var ctx = this.ctx;
                    $.each(this.lines, function() {
                        ctx.beginPath();
                        $.each(this, function(i) {
                            ctx[i === 0 ? 'moveTo' : 'lineTo'](this[0] * scale, this[1] *
                            scale);
                        });
                        ctx.stroke();
                    });
                },

                /** Draw a signature from its <code>data:</code> URL.
                	<p>Note that this does not reconstruct the internal representation!</p>
                	@memberof Signature
                	@private
                	@param {string} sig The <code>data:</code> URL containing an image.
                	@param {number} scale A scaling factor. */
                _drawDataURL: function(sig, scale) {
                    var image = new Image();
                    var context = this.ctx;
                    image.onload = function() {
                        context.drawImage(this, 0, 0, image.width * scale, image.height * scale);
                    };
                    image.src = sig;
                },

                /** Determine whether or not any drawing has occurred.
                	@memberof Signature
                	@return {boolean} <code>true</code> if not signed, <code>false</code> if signed.
                	@example if ($(selector).signature('isEmpty')) ... */
                isEmpty: function() {
                    return this.lines.length === 0;
                },

                /** Remove the signature functionality.
                	@memberof Signature
                	@private */
                _destroy: function() {
                    this.element.removeClass(this.widgetFullName || this.widgetBaseClass);
                    $(this.canvas).remove();
                    this.canvas = this.ctx = this.lines = null;
                    this._mouseDestroy();
                }
            };

            if (!$.Widget.prototype._destroy) {
                $.extend(signatureOverrides, {
                    /* Remove the signature functionality. */
                    destroy: function() {
                        this._destroy();
                        $.Widget.prototype.destroy.call(this); // Base widget handling
                    }
                });
            }

            if ($.Widget.prototype._getCreateOptions === $.noop) {
                $.extend(signatureOverrides, {
                    /* Restore the metadata functionality. */
                    _getCreateOptions: function() {
                        return $.metadata && $.metadata.get(this.element[0])[this.widgetName];
                    }
                });
            }

            $.widget('kbw.signature', $.ui.mouse, signatureOverrides);

            // Make some things more accessible
            $.kbw.signature.options = $.kbw.signature.prototype.options;

        })(jQuery);
    </script>
    <script>
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        sig.focus();
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>
    <script>
        const mediaQuery = window.matchMedia('(max-width: 668px)');
        var canvas = document.querySelector("canvas");
        var ctx = canvas.getContext("2d");
        if (mediaQuery.matches) {
            var cw = (canvas.width = 300),
                cx = cw / 2;
            var ch = (canvas.height = 200),
                cy = ch / 2;
        } else {
            var cw = (canvas.width = 450),
                cx = cw / 2;
            var ch = (canvas.height = 200),
                cy = ch / 2;
        }
        ctx.strokeStyle = "#fff";
        var dibujando = false;
        var m = {
            x: 0,
            y: 0
        };

        var eventsRy = [{
                event: "mousedown",
                func: "onStart"
            },
            {
                event: "touchstart",
                func: "onStart"
            },
            {
                event: "mousemove",
                func: "onMove"
            },
            {
                event: "touchmove",
                func: "onMove"
            },
            {
                event: "mouseup",
                func: "onEnd"
            },
            {
                event: "mouseout",
                func: "onEnd"
            },
            {
                event: "touchend",
                func: "onEnd"
            }
        ];

        function onStart(evt) {
            m = oMousePos(canvas, evt);
            ctx.beginPath();
            dibujando = true;
        }

        function onMove(evt) {
            if (dibujando) {
                ctx.moveTo(m.x, m.y);
                m = oMousePos(canvas, evt);
                ctx.lineTo(m.x, m.y);
                ctx.stroke();
            }
        }

        function onEnd(evt) {
            dibujando = false;
            console.log($.kbw.signature.options);
        }

        function oMousePos(canvas, evt) {
            var ClientRect = canvas.getBoundingClientRect();
            var e = evt.touches ? evt.touches[0] : evt;
            return {
                x: Math.round(e.clientX - ClientRect.left),
                y: Math.round(e.clientY - ClientRect.top)
            };
        }

        for (var i = 0; i < eventsRy.length; i++) {
            (function(i) {
                var e = eventsRy[i].event;
                var f = eventsRy[i].func;
                console.log(f);
                canvas.addEventListener(e, function(evt) {
                    evt.preventDefault();
                    window[f](evt);
                    return;
                }, false);
            })(i);
        }

        clear.addEventListener(
            "click",
            function() {
                ctx.clearRect(0, 0, cw, ch);
            },
            false
        );
    </script>
</body>

</html>
