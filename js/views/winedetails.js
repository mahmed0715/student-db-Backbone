window.WineView = Backbone.View.extend({
    initialize: function() {
        this.render();
    },
    render: function() {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    },
    events: {
        "change": "change",
        "click .save": "beforeSave",
        "click .delete": "deleteWine",
        "dragenter #picture": "dropHandler0",
        "dragover #picture": "dropHandler0",
        "drop #picture": "dropHandler",
        "click #picture": "browsePic",
        "change input[type='file']": "handlePicSelect"
    },
    change: function(event) {
        // Remove any existing alert message
        utils.hideAlert();

        // Apply the change to the model
        var target = event.target;
        var change = {};
        change[target.name] = target.value;
        this.model.set(change);

        // Run validation rule (if any) on changed item
        var check = this.model.validateItem(target.id);
        if (check.isValid === false) {
            utils.addValidationError(target.id, check.message);
        } else {
            utils.removeValidationError(target.id);
        }
    },
    beforeSave: function() {
        var self = this;
        var check = this.model.validateAll();
        if (check.isValid === false) {
            utils.displayValidationErrors(check.messages);
            return false;
        }
        // Upload picture file if a new file was dropped in the drop area
        if (this.pictureFile) {
            this.model.set("picture", this.pictureFile.name);
            utils.uploadFile(this.pictureFile,
                    function() {
                        self.saveWine();
                    }
            );
        } else {
            this.saveWine();
        }
        return false;
    },
    saveWine: function() {
        var self = this;
        this.model.save(null, {
            success: function(model) {
                self.render();
                app.navigate('wines/' + model.id, false);
                utils.showAlert('Success!', 'Wine saved successfully', 'alert-success');
            },
            error: function() {
                utils.showAlert('Error', 'An error occurred while trying to delete this item', 'alert-error');
            }
        });
    },
    deleteWine: function() {
        this.model.destroy({
            success: function() {
                alert('Wine deleted successfully');
                window.history.back();
            }
        });
        return false;
    },
    dropHandler: function(event) {
        console.log('--', event.originalEvent.dataTransfer.files.length);
        this.handleFile(event.originalEvent.dataTransfer.files[0]);
        event.preventDefault();
    },
    handleFile: function(file) {
        this.pictureFile = file;
        // Read the image file from the local file system and display it in the img tag
        var reader = new FileReader();
        reader.onloadend = function() {
            $('#picture').attr('src', reader.result);
        };
        reader.readAsDataURL(this.pictureFile);
    },
    dropHandler0: function(event) {
        event.stopPropagation();
        event.preventDefault();
        event.originalEvent.dataTransfer.dropEffect = 'copy';
    },
    browsePic: function(e) {
        this.$('input[type="file"]').trigger('click');
    },
    handlePicSelect: function(e) {
        this.handleFile(e.target.files[0]);
    }

});