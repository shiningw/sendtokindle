import eventHandler from "./lib/eventHandler"
import helper from "./helper";
import http from "./lib/http";
import "./css/settings.scss";

eventHandler.add('click', '#sendtokindle-app-settings', 'input[type="button"]', function (e) {
    e.preventDefault();
    let data = helper.getFormData(this.getAttribute("data-rel"));
    let url = OC.generateUrl(this.getAttribute("path"));
    http.create(url).setData(data).setHandler(data => {
        if (data.error) {
            helper.info(data.error)
        } else if (data.message) {
            helper.info(data.message)
        }
    }).send();
});
