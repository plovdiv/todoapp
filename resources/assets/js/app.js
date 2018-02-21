import Inflection from "inflection"


require('./bootstrap');
window.Vue = require('vue');


import controllers from './controllers/index';

class Application {

    constructor() {

        document.addEventListener("DOMContentLoaded", () => {
            const [controllerName, actionName] = document.body.getAttribute("data-page").split(":").slice(-2)
            const controllerClassName = Inflection.camelize(controllerName)
            const actionMethodName = Inflection.camelize(actionName, true)

            if (controllers[controllerClassName]) {
                const controller = new controllers[controllerClassName]()
                if (controller[actionMethodName]) {
                    controller[actionMethodName]()
                }
            }
        })
    }
}

new Application()

