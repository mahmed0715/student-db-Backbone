window.Wine = Backbone.Model.extend({
    urlRoot: "api/wines",
    initialize: function() {
        this.validators = {};

        this.validators.name = function(value) {
            return value.length > 0 ? {isValid: true} : {isValid: false, message: "You must enter a name"};
        };

//        this.validators.grapes = function (value) {
//            return value.length > 0 ? {isValid: true} : {isValid: false, message: "You must enter a grape variety"};
//        };
//
//        this.validators.country = function (value) {
//            return value.length > 0 ? {isValid: true} : {isValid: false, message: "You must enter a country"};
//        };
    },
    validateItem: function(key) {
        return (this.validators[key]) ? this.validators[key](this.get(key)) : {isValid: true};
    },
    // TODO: Implement Backbone's standard validate() method instead.
    validateAll: function() {

        var messages = {};

        for (var key in this.validators) {
            if (this.validators.hasOwnProperty(key)) {
                var check = this.validators[key](this.get(key));
                if (check.isValid === false) {
                    messages[key] = check.message;
                }
            }
        }

        return _.size(messages) > 0 ? {isValid: false, messages: messages} : {isValid: true};
    },
    defaults: {
        id: null,
        name: "",
        fatherName: "",
        motherName: "",
        roll: "",
        email: "",
        dob: "",
        gender: "",
        religion: "",
        medium: "",
        village: "",
        post: "",
        upozilla: "",
        district: "",
        mobile: "",
        trade: "",
        nationality: "",
        jscBoard: "",
        jscYear: "",
        jscRoll: "",
        jscResult: "",
        sscBoard: "",
        sscYear: "",
        sscRoll: "",
        sscResult: "",
        description: "",
        picture: 'generic.png'
    }
});

window.WineCollection = Backbone.Collection.extend({
    model: Wine,
    url: "api/wines"

});