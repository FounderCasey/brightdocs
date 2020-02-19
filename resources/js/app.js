import Landing from "./components/Landing";
import Home from "./components/Home";
import Dashboard from "./components/Dashboard";
import RegisterUser from "./components/RegisterUser.vue";
import Articles from "./components/Articles.vue";
import TenantNavbar from "./components/TenantNavbar";
import TenantFoot from "./components/TenantFoot";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faUserSecret,
    faBold,
    faItalic,
    faStrikethrough,
    faUnderline,
    faCode,
    faParagraph,
    faListUl,
    faListOl,
    faQuoteRight,
    faTerminal,
    faImage
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
    faUserSecret,
    faBold,
    faItalic,
    faStrikethrough,
    faUnderline,
    faCode,
    faParagraph,
    faListUl,
    faListOl,
    faQuoteRight,
    faTerminal,
    faImage
);

window.Vue = require("vue");

const app = new Vue({
    el: "#app",
    components: {
        Landing,
        Home,
        Dashboard,
        Articles,
        "font-awesome-icon": FontAwesomeIcon,
        "register-user": RegisterUser,
        "tenant-navbar": TenantNavbar,
        "tenant-foot": TenantFoot
    }
});
