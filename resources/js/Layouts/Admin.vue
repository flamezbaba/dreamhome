<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { ref, watch, onMounted, computed } from "vue";
import {
    mdiOfficeBuilding,
    mdiCogOutline,
    mdiLogoutVariant,
    mdiMenu,
    mdiClipboardTextClock,
    mdiSquareRoundedOutline,
    mdiClose,
} from "@mdi/js";
import { adminNavLinks } from "@/Utils/navLinks";

import NavLink from "@/Components/Navigation/NavLink.vue";
import ConfirmModal from "@/Components/Modals/Confirm.vue";
import PopUpFlashMessage from "@/Components/Modals/PopUpFlashMessages.vue";

defineProps({
    title: String,
});

const emit = defineEmits(["onModalActionTwo"]);

const showModal = ref(false);
const showMobileNav = ref(false);
const confirmModalData = ref({});
const pageProps = computed(() => usePage().props);

const openConfirmModal = (data) => {
    confirmModalData.value = data;
    showModal.value = true;
};

const runConModalActionTwo = (payload) => {
    emit("onModalActionTwo", payload);
    closeConfirmModal();
};

const closeConfirmModal = () => {
    showModal.value = false;
};

// const navLinks = computed(() => {
//     return adminNavLinks;
// });

const navLinks = ref([
    {
        title: "Users",
        icon: mdiSquareRoundedOutline,
        mainRoute: "admin.user",
        link: route("admin.user"),
    },
    {
        title: "Orders",
        icon: mdiSquareRoundedOutline,
        mainRoute: "admin.order",
        link: route("admin.order"),
    },
    {
        title: "Properties",
        icon: mdiSquareRoundedOutline,
        mainRoute: "admin.property",
        link: route("admin.property"),
        subMenu: [
            {
                title: "Create Property",
                link: route("admin.property.create"),
            },
            {
                title: "View All",
                link: route("admin.property"),
            },
        ],
    },
    {
        title: "Settings",
        icon: mdiSquareRoundedOutline,
        mainRoute: "admin.settings.bank",
        link: route("admin.settings.bank"),
    },
]);

const settingsLink = computed(() => {
    // if (pageProps.value.auth.staff.rank == 1) {
    //     return route("admin.setting.profile");
    // }
    // if (pageProps.value.auth.staff.rank == 4) {
    //     return route("manager.setting.profile");
    // }
    // if (pageProps.value.auth.staff.rank == 5) {
    //     return route("officer.setting.profile");
    // }
});

onMounted(() => {
    // console.log("from layout",pageProps.value.auth.staff);
});
</script>

<template>
    <div>
        <Head :title="title" />
        <div class="page-wrapper w-full flex md:flex-col">
            <PopUpFlashMessage />
            <ConfirmModal
                :show="showModal"
                :modalData="confirmModalData"
                @modalClose="closeConfirmModal"
                @modalActionTwo="runConModalActionTwo"
            />
            <slot name="page-modal"></slot>
            <div class="laptop-sidebar w-[300px] md:hidden">
                <div
                    class="logo flex p-[20px] justify-start items-center gap-1"
                >
                    <svg-icon
                        type="mdi"
                        :path="mdiOfficeBuilding"
                        :size="30"
                    ></svg-icon>
                    <span>DreamCard Homes</span>
                </div>
                <div class="menu-wrapper">
                    <div
                        class="link-wrapper"
                        v-for="(nav, n) in navLinks"
                        :key="n"
                    >
                        <NavLink
                            :topLinkTitle="nav.title"
                            :topLinkUrl="nav.link"
                            :hasSubMenu="nav.subMenu ? true : false"
                            :subMenu="nav.subMenu"
                            :active="
                                route().current(`${nav.mainRoute}.*`) ||
                                route().current(`${nav.mainRoute}`)
                            "
                        >
                            <template #svg>
                                <svg-icon
                                    type="mdi"
                                    :path="nav.icon"
                                ></svg-icon>
                            </template>
                        </NavLink>
                    </div>
                </div>
                <div class="bottom-menu">
                    <div class="link-wrapper">
                        <NavLink
                            topLinkTitle="Log Out"
                            :topLinkUrl="route('admin.login')"
                        >
                            <template #svg>
                                <svg-icon
                                    type="mdi"
                                    :path="mdiLogoutVariant"
                                ></svg-icon>
                            </template>
                        </NavLink>
                    </div>
                    <div class="user-info">
                        <img
                            src="@/assets/img/avatar.jpg"
                            class="ring-2 ring-[#eee]"
                            alt=""
                        />
                        <div class="info">
                            <p class="capitalize">Admin</p>
                            <p class="uppercase">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mobile-sidebar flex justify-between lg:hidden md:w-full"
            >
                <div class="logo flex justify-start items-center gap-1">
                    <svg-icon
                        type="mdi"
                        :path="mdiOfficeBuilding"
                        :size="30"
                    ></svg-icon>
                    <span>DreamCard</span>
                </div>

                <div
                    class="nav-button cursor-pointer"
                    @click="showMobileNav = true"
                >
                    <svg-icon type="mdi" :path="mdiMenu" :size="30"></svg-icon>
                </div>

                <div class="menu-overlay" v-if="showMobileNav">
                    <div class="top w-full flex justify-between">
                        <div class="flex justify-start items-center gap-1">
                            <svg-icon
                                type="mdi"
                                :path="mdiOfficeBuilding"
                                :size="30"
                            ></svg-icon>
                            <span>Dream CARD</span>
                        </div>

                        <div
                            class="close-button"
                            @click="showMobileNav = false"
                        >
                            <svg-icon
                                type="mdi"
                                :path="mdiClose"
                                :size="30"
                            ></svg-icon>
                        </div>
                    </div>
                    <div class="menu-wrapper">
                        <div
                            class="link-wrapper"
                            v-for="(nav, n) in navLinks"
                            :key="n"
                        >
                            <NavLink
                                :topLinkTitle="nav.title"
                                :topLinkUrl="nav.link"
                                :hasSubMenu="nav.subMenu ? true : false"
                                :subMenu="nav.subMenu"
                                :active="
                                    route().current(`${nav.mainRoute}.*`) ||
                                    route().current(`${nav.mainRoute}`)
                                "
                            >
                                <template #svg>
                                    <svg-icon
                                        type="mdi"
                                        :path="nav.icon"
                                    ></svg-icon>
                                </template>
                            </NavLink>
                        </div>
                    </div>
                    <div class="bottom-menu">
                        <div class="link-wrapper">
                            <NavLink
                                topLinkTitle="Log Out"
                                :topLinkUrl="route('admin.login')"
                            >
                                <template #svg>
                                    <svg-icon
                                        type="mdi"
                                        :path="mdiLogoutVariant"
                                    ></svg-icon>
                                </template>
                            </NavLink>
                        </div>
                        <div class="user-info">
                            <img
                                src="@/assets/img/avatar.jpg"
                                class="ring-2 ring-[#eee]"
                                alt=""
                            />
                            <div class="info">
                                <p class="capitalize">Admin</p>
                                <p class="uppercase">Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="content-wrapper w-[calc(100%_-_300px)] left-[300px] md:left-0 md:w-full"
            >
                <slot
                    name="main-content"
                    :openConfirmModal="openConfirmModal"
                ></slot>
                <!-- <slot  /> -->
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
.page-wrapper {
    width: 100%;
    min-height: 100vh;
    position: relative;

    .laptop-sidebar {
        position: fixed;
        width: 300px;
        background: #172439;
        height: 100vh;
        color: #fff;

        .logo {
            width: 100%;
        }

        .menu-wrapper {
            overflow-y: scroll;
            overflow-x: hidden;
            height: calc(100% - 120px);
            padding-bottom: 100px;
            width: 100%;

            .link-wrapper {
                width: calc(100% - 40px);
                margin: 10px 20px;
            }
        }

        .bottom-menu {
            position: absolute;
            bottom: 0;
            background-color: #172439;
            width: 100%;

            .link-wrapper {
                width: calc(100% - 40px);
                margin: 5px 20px;
            }

            .user-info {
                display: flex;
                gap: 13px;
                padding-left: 20px;
                padding-right: 20px;
                padding-top: 10px;
                padding-bottom: 10px;

                img {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    object-fit: cover;
                }

                .info {
                    p {
                        &:nth-child(1) {
                            font-weight: 500;
                        }
                    }
                }
            }
        }
    }

    .mobile-sidebar {
        background-color: #172439;
        padding: 20px;

        .logo {
            color: #fff;
            font-weight: 700;
        }

        .nav-button {
            color: #fff;
        }

        .menu-overlay {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 500;
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            overflow: scroll;
            background: #172439;
            color: #fff;

            .top {
                background-color: rgba($color: #172439, $alpha: 0.6);
                color: #fff;
                font-weight: 800;
                padding: 15px;
            }

            .menu-wrapper {
                overflow-y: scroll;
                overflow-x: hidden;
                height: calc(100% - 120px);
                padding-bottom: 100px;
                width: 100%;

                .link-wrapper {
                    width: calc(100% - 40px);
                    margin: 10px 20px;
                }
            }

            .bottom-menu {
                position: absolute;
                bottom: 0;
                background-color: #172439;
                width: 100%;

                .link-wrapper {
                    width: calc(100% - 40px);
                    margin: 5px 20px;
                }

                .user-info {
                    display: flex;
                    gap: 13px;
                    padding-left: 20px;
                    padding-right: 20px;
                    padding-top: 10px;
                    padding-bottom: 10px;

                    img {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        object-fit: cover;
                    }

                    .info {
                        p {
                            &:nth-child(1) {
                                font-weight: 500;
                            }
                        }
                    }
                }
            }
        }
    }

    .content-wrapper {
        /* background-color: #8cbae3; */
        background-color: #ececec;
        position: relative;
        min-height: 100vh;
    }
}
</style>
