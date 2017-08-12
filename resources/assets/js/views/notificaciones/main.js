/**
* Class MainNotificationView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MainNotificationView = Backbone.View.extend({

        el: '#notification-main',
        template: _.template( ($('#add-notification-tpl').html() || '') ),
        events: {
            'click .btn-search': 'search',
            'click .btn-clear': 'clear',
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Attributes
            this.$searchDate = this.$('#search_fecha');
            this.$searchEstado = this.$('#search_estado');
            this.$searchType = this.$('#search_typenotification');

            // Coleccion
            this.notificationList = new app.NotificationList();
            this.notificationList.fetch({ reset: true });

            this.listenTo( this.notificationList, 'reset', this.addAllNotfication );
            this.$wraper = $('#notifications-list');
        },

        search: function(e){
            e.preventDefault();
            var _this = this;

            // Update machine
            $.ajax({
                url: window.Misc.urlFull( Route.route( 'notificaciones.index') ),
                type: 'GET',
                data: {
                    searchDate: _this.$searchDate.val(),
                    searchType: _this.$searchType.val(),
                    searchEstado: _this.$searchEstado.val()
                },
                beforeSend: function() {
                    window.Misc.setSpinner( _this.spinner );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( _this.spinner );
                _this.$wraper.empty();

                _.each( resp, function(item){
                    _this.call = 'A';
                    _this.addOneNotification(item);
                });
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( _this.spinner );
                alertify.error(thrownError);
            });
        },

        /**
        * Render view task by model
        * @param Object NotificationModel Model instance
        */
        addOneNotification: function(NotificationModel){
            var view = new app.NotificationItemView({
                model: NotificationModel,
                parameters: {
                    call: this.call,
                }
            });

            this.$wraper.append( view.render().el );
        },

        addAllNotfication: function(){
            this.$wraper.empty();
            this.notificationList.forEach( this.addOneNotification, this );
        },

        clear: function(e){
            e.preventDefault();

            window.Misc.clearForm( $('#form-koi-search-tercero-component') );
        },
    });
})(jQuery, this, this.document);
