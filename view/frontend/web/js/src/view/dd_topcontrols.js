var DD_Topcontrols = DD_panel.extend({
    object_id: 'dd-top-controls',
    class_name: 'dd-designer-topcontrols',
    
    init: function (parent, main) {
        this.parent = parent;
        this.main = main;
        this._super({
            'id': this.object_id,
            'class': this.class_name,
            'parent': parent
        });
        this.add();
    },
    
    _addElements: function() {
        this.addPhotoButton();
        this.addTextButton();
        this.addFromLibraryButton();
        if(this.main.options.onClose) {
            this.addCloseButton(this.main.options.onClose);
        }
    },
    
    
    addCloseButton: function(onClose) {
        
        new DD_closeButton(this.self, onClose);
        
    },
    
    addPhotoButton: function() {
        if(!this._s('addphoto')) {
            return;
        }
        new DD_AddphotoButton(this.self);
    },
    
    addTextButton: function() {
        if(!this._s('addtext')) {
            return;
        }
        new DD_AddtextButton(this.self);
    },
    
    addFromLibraryButton: function(){
        if(!this._s('addfromlibrary')) {
            return;
        }
        new DD_AddfromLibraryButton(this.self);
    }
    
});
