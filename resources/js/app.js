import "./bootstrap";
import { createApp } from "vue";
import App from "./layout/App.vue";
import vuetify from "./vuetify";
import "../css/index.css";

createApp(App).use(vuetify).mount("#app");
