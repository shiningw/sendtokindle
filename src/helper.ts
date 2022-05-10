import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"
type data = {
    [index: string]: any
}
const helper = {

    getFormData(selector: string | HTMLElement) {
        let element: HTMLElement;
        if (selector instanceof Element) {
            element = selector;
        }
        if (typeof selector === "string") {
            if (selector.substring(0, 1) != '#') {
                selector = '#' + selector;
            }
            element = document.querySelector(selector)
        }
        if (!element) {
            console.error("no element matches");
        }
        let data: data = {
            path: element.getAttribute('path'),
        }
        //if the targeted element is not of input or select type, search for such elements below it
        if (!['SELECT', 'INPUT'].includes(element.nodeName.toUpperCase())) {
            const nodeList = element.querySelectorAll('input,select')
            nodeList.forEach((element) => {
                if (element.hasAttribute('type') && element.getAttribute('type') === 'button') {
                    return;
                }
                this.getData(element, data)
            })
        } else {
            this.getData(element, data)
        }
        return data;
    },
    getData(element: HTMLInputElement, data: data
    ) {
        for (let prop in element.dataset) {
            data[prop] = element.dataset[prop];
        }
        const key = element.getAttribute('id') || element.getAttribute('name')
        data[key] = (<HTMLInputElement>element).value
        return data
    },
    _message: function (message:string, options = {}) {
        message = message || "Empty"
        const defaults:Toastify.Options = {
            text: message,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            // backgroundColor: "#295b86",
            stopOnFocus: true, // Prevents dismissing of toast on hover
            onClick: function () { }, // Callback after click
        }
        Object.assign(defaults, options);
        Toastify(defaults).showToast();
    },
    error: function (message:string, duration = 20000) {
        let options = {
            style: {
                color: '#721c24',
                'background-color': '#f8d7da',
                'border-color': '#f5c6cb',
            },
            duration: duration,
            backgroundColor: '#f8d7da',
        }
        helper._message(message, options);
    },
    info: function (message:string, duration = 2000) {
        const options = {
            style: {
                color: '#004085',
                'background-color': '#cce5ff',
                'border-color': '#b8daff',
            },
            duration: duration,
            text: message,
            backgroundColor: '#cce5ff',
        }
        helper._message(message, options);
    },
    warn: function (message:string, duration = 2000) {
        const options = {
            style: {
                color: '#856404',
                'background-color': '#fff3cd',
                'border-color': '#ffeeba',
            },
            duration: duration,
            backgroundColor: '#fff3cd',
        }
        helper._message(message, options);
    },
    message: function (message:string, duration = 2000) {
        helper.info(message, duration);
    },
}

export default helper;