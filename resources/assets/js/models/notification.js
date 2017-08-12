/**
* Class NotificationModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function (window, document, undefined) {

    app.NotificationModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull( Route.route('notificaciones.index') );
        },
        idAttribute: 'id',
        defaults: {
            'notificacion_tercero': '',
            'notificacion_tiponotificacion': '',
            'notificacion_visto': '',
            'notificacion_fh_visto': '',
            'notificacion_fecha': '',
            'notificacion_hora': '',
            'notificacion_url': '',
            'notificacion_descripcion': '',
            'notificacion_titulo': '',
        }
    });
})(this, this.document);
