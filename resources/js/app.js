import "./bootstrap";
import { createApp } from "vue";
import App from "./layout/App.vue";
import vuetify from "./vuetify";
import "../css/index.css";
import "@mdi/font/css/materialdesignicons.css";

createApp(App).use(vuetify).mount("#app");
