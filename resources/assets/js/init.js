/**
* Init Class
*/

/*global*/
var app = app || {};

(function ($, window, document, undefined) {

    var InitComponent = function() {

        //Init Attributes
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    String.prototype.replaceAll = function(search, replace)
    {
        if(!replace)
            return this;
        return this.replace(new RegExp('[' + search + ']', 'g'), replace);
    };

    InitComponent.prototype = {

        /**
        * Constructor or Initialize Method
        */
        initialize: function () {
            //Initialize
            this.initApp();
            this.initICheck();
            this.initAlertify();
            this.initSelect2();
            this.initToUpper();
            this.initSpinner();
            this.initInputMask();
            this.initDatePicker();
        },

        /**
        * Init Backbone Application
        */
        initApp: function () {
            window.app.AppRouter.start();
        },

        /**
        * Init icheck
        */
        initICheck: function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-green',
                radioClass: 'iradio_minimal-green'
            });
        },

        /**
        * Init alertify
        */
        initAlertify: function () {
            alertify.logPosition("bottom right");
        },

        /**
        * Init select2
        */
        initSelect2: function () {
            $('.select2-default').select2({ language: 'es', placeholder: 'Seleccione', allowClear: false });
            $('.select2-default-clear').select2({ language: 'es', placeholder: 'Seleccione', allowClear: true });
        },

        /**
        * Init toUpper
        */
        initToUpper: function () {
            $('.input-toupper').change(function(){
                $(this).val( $(this).val().toUpperCase() );
            });

            $('.input-lower').change(function(){
                var dato = $(this).val( $(this).val().toLowerCase() );
                var reg = /[^a-z0-9]/i;
                var valor = '';
                for(var i=0; i <= dato.val().length-1; i++){
                    if( !reg.test(dato.val().charAt(i)) ){
                        dato.val().replace(reg,'');
                        valor += dato.val().charAt(i);
                    }
                }
                $(this).val( valor );
           });
        },

        /**
        * Init initSpinner
        */
        initSpinner: function () {
            $('.spinner-percentage').spinner({
                step: 0.1,
                start: 0,
                min: 0,
                max: 100,
                numberFormat: "n",
                stop: function( event, ui ) {
                    if(!_.isNull(this.value) && !_.isUndefined(this.value) && !_.isEmpty(this.value)) {
                        if(!$.isNumeric( this.value ) || this.value > 100 || this.value < 0){
                            $(this).spinner( 'value', 0 );
                        }
                    }
               }
            });
        },

        /**
        * Init inputMask
        */
        initInputMask: function () {

            $("[data-mask]").inputmask();

            $("[data-currency]").inputmask({
                radixPoint: ",",
                alias: 'currency',
                removeMaskOnSubmit: true,
                unmaskAsNumber: true,
                min: 0,
                onBeforeMask: function (value, opts) {
                    var processedValue = value || 0;

                    return processedValue;
                },
                oncleared: function  (event) {
                    var $input = $(this);

                    if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                        $input.inputmask('setvalue', 0);
                    }
                },
            });

            $("[data-currency-price]").inputmask({
                radixPoint: ",",
                groupSeparator: ".",
                alias: 'currency',
                digits: 2,
                unmaskAsNumber: true,
                removeMaskOnSubmit: true,
                autoGroup: true,
                rightAlign: false,
                oncleared: function  (event) {
                    var $input = $(this);
                    if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                        $input.inputmask('setvalue', 0);
                    }
                },
            });

            $("[data-currency-precise]").inputmask({
                radixPoint: ",",
                alias: 'currency',
                removeMaskOnSubmit: true,
                unmaskAsNumber: true,
                min: 0,
                digits: 0,
                onBeforeMask: function (value, opts) {
                    var processedValue = value || 0;

                    return processedValue;
                },
                oncleared: function  (event) {
                    var $input = $(this);

                    if( this.inputmask.unmaskedvalue() == null || isNaN(parseFloat(this.inputmask.unmaskedvalue())) ) {
                        $input.inputmask('setvalue', 0);
                    }
                },
            });
        },

        /**
        * Init initValidator
        */
        initValidator: function () {

            $('form[data-toggle="validator"]').each(function () {
                var $form = $(this)
                $.fn.validator.call($form, $form.data())
            })
        },

        /**
        * Init Datepicker
        */
        initDatePicker: function () {

            $('.datepicker').datepicker({
                autoclose: true,
                language: 'es',
                format: 'yyyy-mm-dd'
            });
        }
    };

    //Init App Components
    //-----------------------
    $(function() {
        window.initComponent = new InitComponent();
        window.initComponent.initialize();
    });

})(jQuery, this, this.document);