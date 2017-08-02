/**
* Class MainAgendaTecnicaView  of Backbone Router
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainAgendaTecnicaView = Backbone.View.extend({

        el: '#soportetecnico-main',
        templateEvent: _.template( ($('#add-info-event-tpl').html() || '') ),
        events: {
            'click .btn-search': 'changeTechnical',
            'click .btn-clear': 'clearFilters',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // Initialize
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            // Reference to fields
            this.spinnerCalendar = this.$('#spinner-calendar');
            this.$modalEvent = $('#modal-event-component');
            this.$calendar = this.$('#calendar');
            
            this.referenceCalendar();
        },

        /**
        * fires libraries js
        */
        ready: function () {
            if( typeof window.initComponent.initInputMask == 'function' )
                window.initComponent.initSelect2();
        },

        referenceCalendar: function (){
            var _this = this;

            $.ajax({
                type: 'GET',
                url: window.Misc.urlFull( Route.route('agendatecnica.index') ),
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinnerCalendar );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinnerCalendar );

                if(!_.isUndefined(resp.success)) {
                    // response success or error
                    var text = resp.success ? '' : resp.errors;
                    if( _.isObject( resp.errors ) ) {
                        text = window.Misc.parseErrors(resp.errors);
                    }
                    if( !resp.success ) {
                        alertify.error(text);
                        return;
                    }

                    // Render calendar
                    _this.calendar();

                    // Remove event && addEvenet && renderEvent lib -> fullcalendar.io
                    _this.$calendar.fullCalendar('removeEvents');
                    _this.$calendar.fullCalendar('addEventSource', resp.ordenes);       
                    _this.$calendar.fullCalendar('rerenderEvents');
                }   
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinnerCalendar );
                alertify.error(thrownError);
            });
        },

        /**
        * Instanceof Calendar 
        */
        calendar: function(){
            var _this = this;

            this.$calendar.fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(calEvent, jsEvent, view) {
                    _this.$modalEvent.find('.content-modal').html( _this.templateEvent( calEvent ) );
                    _this.$modalEvent.find('.modal-title').text( calEvent.title.trim() );
                    _this.$modalEvent.modal('show');
                }
            });
        },

        /**
        * Event Change Asesor
        */
        changeTechnical: function (e) {
            e.preventDefault();

            var _this = this,
                technical = this.$('#search_technical').val(),
                tercero = this.$('#search_tercero').val();

            if( typeof(technical) !== 'undefined' && !_.isUndefined(technical) && !_.isNull(technical) && technical != '' || typeof(tercero) !== 'undefined' && !_.isUndefined(tercero) && !_.isNull(tercero) && tercero != '' ){
                $.ajax({
                    type: 'GET',
                    url: window.Misc.urlFull( Route.route('agendatecnica.index') ),
                    data: { 
                        search_technical: technical,
                        search_tercero: tercero,
                    },
                    beforeSend: function() {
                        window.Misc.setSpinner( _this.spinnerCalendar );
                    }
                })
                .done(function(resp) {
                    window.Misc.removeSpinner( _this.spinnerCalendar );

                    if(!_.isUndefined(resp.success)) {
                        // response success or error
                        var text = resp.success ? '' : resp.errors;
                        if( _.isObject( resp.errors ) ) {
                            text = window.Misc.parseErrors(resp.errors);
                        }
                        if( !resp.success ) {
                            alertify.error(text);
                            return;
                        }

                        // Remove event && addEvenet && renderEvent lib -> fullcalendar.io
                        _this.$calendar.fullCalendar('removeEvents');
                        _this.$calendar.fullCalendar('addEventSource', resp.ordenes);       
                        _this.$calendar.fullCalendar('rerenderEvents');
                    }   
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    window.Misc.removeSpinner( _this.spinnerCalendar );
                    alertify.error(thrownError);
                });
            }
        },

        clearFilters: function(e){
            e.preventDefault();

            this.referenceCalendar();
            window.Misc.clearForm( $('#form-koi-search-tercero-component') );
        },
    });

})(jQuery, this, this.document);
