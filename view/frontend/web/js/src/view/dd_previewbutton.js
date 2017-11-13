var DD_previewButton = DD_button.extend({
    object_id: 'dd-main-preview-button',
    class_name: 'dd-main-button fa fa-eye',
    
    init: function(parent) {
        var options = {
            parent: parent,
            id: this.object_id,
            class: this.class_name,
            tooltip_text: this._('preview'),
            fa: true,
            tooltip: true,
            tooltip_position: {
                x: 'center',
                y: 'top'
            },
            tooltip_outside: 'y'
        }
        this._super(options);
    }
});

