var ComponentsSelect2 = function() {
    var e = function() {
        function e(e) {
            if (e.loading) return e.text;
            var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" + e.owner.avatar_url + "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";
            return e.description && (t += "<div class='select2-result-repository__description'>" + e.description + "</div>"), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + e.watchers_count + " Watchers</div></div></div></div>"
        }
        function t(e) {
            return e.full_name || e.text
        }
        $.fn.select2.defaults.set("theme", "bootstrap");
        var s = "Attributes";
        $(".select2, .select2-multiple").select2({
            placeholder: s,
            width: null
        })
    };
    return {
        init: function() {
            e()
        }
    }
}();
$(document).on('ready', function() {
    ComponentsSelect2.init()
});