<script setup>
import { Head, usePage, useForm, router } from "@inertiajs/vue3";
import { ref, watch, onMounted, computed } from "vue";

import basicUtils from "@/Utils/basic.js";

defineProps({
    title: String,
});

const pageProps = computed(() => usePage().props);
const authProps = computed(() => usePage().props.auth.user);
const isAuth = ref(authProps.value ? true : false);
const authModal = ref(null);
const mobileNav = ref(false);

const logoutForm = useForm({
    logout_user: true,
});

const loginForm = useForm({
    login_user: true,
    email: null,
    password: null,
});

const registerForm = useForm({
    register_user: true,
    fullname: null,
    email: null,
    mobile: null,
    password: null,
});

function handleLogin() {
    loginForm.post(route("post.login"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            if (isAuth.value) {
                authModal.value = null;
            }
        },
    });
}

function handleRegister() {
    registerForm.post(route("post.register"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            if (isAuth.value) {
                authModal.value = null;
            }
        },
    });
}

function kk() {
    console.log("ff", router.page);
    console.log("rr", route("search", [{ category: "sale" }]));
}

function handleLogout() {
    logoutForm.post(route("post.login"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {},
    });
}

function doLogin() {
    authModal.value = "login";
}

watch(authProps, (newValue) => {
    if (authProps.value) {
        isAuth.value = true;
    } else {
        isAuth.value = false;
    }
});

watch(mobileNav, () => {
    if (mobileNav.value) {
        basicUtils.disableScroll();
    } else {
        basicUtils.enableScroll();
    }
});

onMounted(() => {
    authModal.value = null;
    basicUtils.enableScroll();
});

import PlainModal from "@/Components/Modals/Plain.vue";
import HomeAlerts from "@/Components/Modals/HomeAlerts.vue";

import { mdiMenu, mdiClose } from "@mdi/js";
</script>

<template>
    <div class="body-wrapper">
        <Head :title="title" />
        <div
            class="w-full h-[70px] pl-[50px] md:pl-[10px] flex items-center justify-between shadow-md shadow-black/10"
        >
            <a :href="route('home')" class="">
            <!-- <a href="#" class="" @click="kk"> -->
                <img src="@/assets/img/logo.png" alt="" class="w-[200px]" />
            </a>
            <div class="md:visible lg:hidden" @click="mobileNav = true">
                <svg-icon type="mdi" :size="25" :path="mdiMenu"></svg-icon>
            </div>
            <nav
                class="lap-nav h-full flex text-lg pr-[50px] md:pr-[10px] font-semibold gap-12 justify-end items-center md:hidden lg:visible"
            >
                <a
                    :href="route('home')"
                    :class="[
                        router.page.component == 'Home/Index' ? 'active' : '',
                    ]"
                    class=""
                    >Home</a
                >
                <a :href="route('search', [{ category: 'rent' }])" class=""
                    >Rent</a
                >
                <a :href="route('search', [{ category: 'sale' }])" class=""
                    >Buy</a
                >
                <a :href="route('search', [{ category: 'shortlets' }])" class=""
                    >Short Lets</a
                >
                <!-- <a :href="route('about')" class="">About Us</a> -->
                <a
                    :class="[
                        router.page.component == 'Home/Contact' ? 'active' : '',
                    ]"
                    :href="route('contact')"
                    class=""
                    >Contact Us</a
                >
                <template v-if="isAuth">
                    <a
                        :href="route('profile')"
                        :class="[
                            router.page.component == 'Home/Profile'
                                ? 'active'
                                : '',
                        ]"
                        class=""
                        >Profile</a
                    >
                    <a @click="handleLogout" class="cursor-pointer">Log Out</a>
                </template>
                <template v-else>
                    <button
                        @click="
                            mobileNav = false;
                            authModal = 'login';
                        "
                        class="bg-blue-800 px-5 py-3 rounded-lg text-white font-semibold"
                    >
                        Register / Login
                    </button>
                </template>
            </nav>
        </div>

        <div v-if="mobileNav" class="mobile-wrapper z-50">
            <div class="modal-body">
                <div class="modal-content h-full w-full">
                    <div class="w-full h-full">
                        <div
                            class="w-full h-[70px] px-[50px] md:px-[10px] py-2 flex items-center justify-between shadow-sm"
                        >
                            <a :href="route('home')" class="">
                                <img
                                    src="@/assets/img/logo.png"
                                    alt=""
                                    class="w-[150px]"
                                />
                            </a>
                            <div @click="mobileNav = false" class="text-white">
                                <svg-icon
                                    type="mdi"
                                    :size="20"
                                    :path="mdiClose"
                                ></svg-icon>
                            </div>
                        </div>
                        <nav
                            class="flex font-bold text-xl text-white flex-col gap-5 items-start px-5 py-5"
                        >
                            <a :href="route('home')" class="">Home</a>
                            <a
                                :href="route('search', [{ category: 'rent' }])"
                                class=""
                                >Rent</a
                            >
                            <a
                                :href="route('search', [{ category: 'sale' }])"
                                class=""
                                >Buy</a
                            >

                            <a
                                :href="
                                    route('search', [{ category: 'shortlets' }])
                                "
                                class=""
                                >Short Lets</a
                            >
                            <!-- <a :href="route('about')" class="">About Us</a> -->
                            <a :href="route('contact')" class="">Contact Us</a>
                            <template v-if="isAuth">
                                <a :href="route('profile')" class="">Profile</a>
                                <a @click="handleLogout" class="cursor-pointer"
                                    >Log Out</a
                                >
                            </template>
                            <template v-else>
                                <button
                                    @click="
                                        mobileNav = false;
                                        authModal = 'login';
                                    "
                                    class="bg-blue-800 px-5 py-3 rounded-lg text-white font-semibold"
                                >
                                    Register / Login
                                </button>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <HomeAlerts />
        <PlainModal :show="authModal == 'login'">
            <template #modal-content>
                <div class="w-[57%] md:w-[84%] flex">
                    <div
                        class="w-[40%] md:hidden lg:visible rounded-tl-xl rounded-bl-xl login-img"
                    ></div>
                    <div
                        class="w-[60%] md:w-full md:rounded-tl-xl md:rounded-bl-xl rounded-tr-xl rounded-br-xl py-[20px] min-h-[400px] px-[40px] bg-white"
                    >
                        <div class="w-full flex justify-between items-center">
                            <p class="text-3xl font-bold">Login</p>
                            <svg-icon
                                @click="authModal = null"
                                type="mdi"
                                :size="20"
                                :path="mdiClose"
                                class="cursor-pointer"
                            ></svg-icon>
                        </div>
                        <div class="w-full mt-5">
                            <div class="w-full mb-6">
                                <p class="text-sm">Email</p>
                                <input
                                    type="email"
                                    class="w-full"
                                    v-model="loginForm.email"
                                />
                            </div>

                            <div class="w-full mb-2">
                                <p class="text-sm">Password</p>
                                <input
                                    type="password"
                                    class="w-full"
                                    v-model="loginForm.password"
                                />
                            </div>

                            <div class="w-full">
                                <p class="text-sm text-right">
                                    Lost Password ?
                                </p>
                            </div>

                            <div class="w-full mt-6">
                                <button
                                    @click="handleLogin"
                                    :class="{
                                        'opacity-25': loginForm.processing,
                                    }"
                                    :disabled="loginForm.processing"
                                    class="bgx-blue rounded-md w-full px-5 py-3 text-white font-semibold inline-flex items-center justify-center"
                                >
                                    Login
                                </button>
                            </div>

                            <div class="w-full mt-5">
                                <p
                                    class="text-center cursor-pointer"
                                    @click="authModal = 'register'"
                                >
                                    Don't you have an account?
                                    <span class="text-blue-1"> Register</span>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </PlainModal>

        <PlainModal :show="authModal == 'register'">
            <template #modal-content>
                <div class="w-[57%] md:w-[84%] flex">
                    <div
                        class="w-[40%] md:hidden lg:visible rounded-tl-xl rounded-bl-xl login-img"
                    ></div>
                    <div
                        class="w-[60%] md:w-full md:rounded-tl-xl md:rounded-bl-xl rounded-tr-xl rounded-br-xl py-[20px] min-h-[400px] px-[40px] bg-white"
                    >
                        <div class="w-full flex justify-between items-center">
                            <p class="text-3xl font-bold">Register</p>
                            <svg-icon
                                @click="authModal = null"
                                type="mdi"
                                :size="20"
                                :path="mdiClose"
                                class="cursor-pointer"
                            ></svg-icon>
                        </div>
                        <div class="w-full mt-5">
                            <div class="w-full mb-6">
                                <p class="text-sm">Fullname</p>
                                <input
                                    type="text"
                                    class="w-full"
                                    v-model="registerForm.fullname"
                                />
                            </div>

                            <div class="w-full mb-6">
                                <p class="text-sm">Phone Number</p>
                                <input
                                    type="text"
                                    id="phone"
                                    class="w-full"
                                    v-model="registerForm.mobile"
                                />
                            </div>

                            <div class="w-full mb-6">
                                <p class="text-sm">Email</p>
                                <input
                                    type="email"
                                    id="email"
                                    class="w-full"
                                    v-model="registerForm.email"
                                />
                            </div>

                            <div class="w-full mb-2">
                                <p class="text-sm">Password</p>
                                <input
                                    type="password"
                                    id="password"
                                    class="w-full"
                                    v-model="registerForm.password"
                                />
                            </div>

                            <div class="w-full mt-6">
                                <button
                                    @click="handleRegister"
                                    :class="{
                                        'opacity-25': registerForm.processing,
                                    }"
                                    :disabled="registerForm.processing"
                                    class="bgx-blue rounded-md w-full px-5 py-3 text-white font-semibold inline-flex items-center justify-center"
                                >
                                    Register
                                </button>
                            </div>

                            <div class="w-full mt-5">
                                <p
                                    class="text-center cursor-pointer"
                                    @click="authModal = 'login'"
                                >
                                    Already have an account?
                                    <span class="text-blue-1"> Login</span>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </PlainModal>
        <slot name="page-modal" :isAuth="isAuth" :doLogin="doLogin"></slot>
        <slot name="page-content" :isAuth="isAuth" :doLogin="doLogin"></slot>
        <footer class="bg-[#1c1c1e]">
            <div
                class="w-full min-h-[200px] text-[#eee] px-[250px] md:px-[20px] py-10 flex gap-10 justify-between md:flex-col md:gap-10 shadow-md shadow-black/10"
            >
                <div class="w-4/12 md:w-full">
                    <p class="capitalize text-xl font-semibold">
                        Dream Card Limited
                    </p>
                    <p class="mt-3">
                        Private Property is Nigeria's fastest growing property
                        portal. With us, you’ll feel right at home when
                        searching for houses, flats, apartments and lands,
                        commercial properties for sales & rent in Nigeria.
                    </p>
                    <p class="mt-4">
                        Office Address: 234, Osapa London, Lagos Nigeria
                    </p>
                </div>

                <div class="w-4/12 md:w-full">
                    <p class="capitalize text-xl font-semibold">
                        Popular State
                    </p>
                    <ul class="mt-3 space-y-3">
                        <li>
                            <a :href="route('search', [{ state: 'lagos' }])"
                                >Properties in Lagos</a
                            >
                        </li>
                        <li>
                            <a :href="route('search', [{ state: 'abuja' }])"
                                >Properties in Abuja</a
                            >
                        </li>
                        <li>
                            <a :href="route('search', [{ state: 'rivers' }])"
                                >Properties in Rivers</a
                            >
                        </li>

                        <li>
                            <a :href="route('search', [{ state: 'enugu' }])"
                                >Properties in Enugu</a
                            >
                        </li>
                    </ul>
                </div>

                <div class="w-4/12 md:w-full">
                    <p class="capitalize text-xl font-semibold">
                        Popular Cities
                    </p>
                    <ul class="mt-3 space-y-3">
                        <li>
                            <a :href="route('search', [{ city: 'ikeja' }])"
                                >Properties in Ikeja</a
                            >
                        </li>
                        <li>
                            <a :href="route('search', [{ city: 'lekki' }])"
                                >Properties in Lekki</a
                            >
                        </li>
                        <li>
                            <a :href="route('search', [{ city: 'ikoyi' }])"
                                >Properties in Ikoyi</a
                            >
                        </li>
                        <li>
                            <a :href="route('search', [{ city: 'ibeju' }])"
                                >Properties in Ibeju-Lekki</a
                            >
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="w-full border-t-[1px] border-t-[#272729] text-[#eee] py-5 flex items-center justify-center"
            >
                <p class="">Copyright © 2023 Dream Card Home Limited</p>
            </div>
            <div class="fixed z-30 bottom-5 right-5">
                <a href="https://wa.me/+2349165892223" target="_blank">
                    <img
                        src="@/assets/img/whatsapp.png"
                        alt=""
                        class="w-[50px] hover:scale-125 duration-300"
                    />
                </a>
            </div>
        </footer>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
.body-wrapper {
    width: 100%;
    min-height: 100vh;
    position: relative;
}

footer {
    background-image: url("@/assets/img/waves.png");
    background-position: center;
}

.lap-nav {
    a {
        transition: all 0.5s ease;
        text-align: center;

        &:hover {
            font-weight: bold;
        }

        &.active {
            @apply bg-blue-800 px-5 py-3 rounded-lg text-white font-semibold;
        }
    }
}

.mobile-wrapper {
    position: fixed;
    background-color: #6b7280;
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    overflow: scroll;

    .modal-body {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;

        .modal-content {
            min-height: 20px;
            overflow: visible;
        }
    }
}

.login-img {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0) 13.85%, #000 100%),
        url("https://dreamhome.demothemesflat.co/wp-content/uploads/2023/09/login-1-1.webp");
    background-size: cover;
}
</style>
