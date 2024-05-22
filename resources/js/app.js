import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createPinia } from "pinia";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import SvgIcon from "vue3-icon";
import vClickOutside from "click-outside-vue3";
import piniaPluginPersistedState from "pinia-plugin-persistedstate";
import CKEditor from "@ckeditor/ckeditor5-vue";
import VueGallery from 'vue-gallery'



const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "DreamCard Homes";

const pinia = createPinia();
pinia.use(piniaPluginPersistedState);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    progress: {
        color: "#29d",
        delay: 100,
        showSpinner: true,
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(vClickOutside)
            .use(CKEditor)
            .component("svg-icon", SvgIcon)
            .component("Head", Head)
            .component("Link", Link)
            .component('VGallery', VueGallery)
            .mount(el);
    },
});

// InertiaProgress.init({ color: "#4B5563" });
