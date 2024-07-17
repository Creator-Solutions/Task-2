import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customTheme",
        themes: {
            customTheme: {
                dark: false,
                colors: {
                    buttonPrimary: "#0B1215",
                    buttonSecondary: "#101720",
                    textPrimary: "#0D1717",
                    textSecondary: "#171717",
                },
            },
        },
    },
});

export default vuetify;
