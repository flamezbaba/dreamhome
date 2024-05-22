<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useBasicStore } from "@/stores/basic";

const props = defineProps({
    page_title: String,
    favs: Array | Object,
    user: Array | Object,
});

const tabs = ref(["Account", "My Orders", "Favourites"]);
const activeTab = ref(0);
const basicStore = useBasicStore();
const favForm = useForm({
    get_favs: true,
    favs: basicStore.favs,
});

const profileForm = useForm({
    update_profile: true,
    fullname: props.user?.fullname,
    email: props.user?.email,
    mobile: props.user?.mobile,
});

const passwordForm = useForm({
    update_password: true,
    password: null,
});

function getFavs() {
    favForm.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {},
    });
}

function updateProfile() {
    profileForm.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {},
    });
}

function updatePassword() {
    passwordForm.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {},
    });
}

onMounted(() => {
    getFavs();
});

onUnmounted(() => {});

import Layout from "@/Layouts/Home.vue";
import PlainModal from "@/Components/Modals/Plain.vue";
import SingleDisplay from "@/Components/SingleDisplay.vue";
import { mdiPhone, mdiEmailFast, mdiMapMarker } from "@mdi/js";
</script>

<template>
    <Layout :title="page_title">
        <template #page-modal> </template>
        <template #page-content>
            <div class="w-full">
                <div
                    class="home-card w-full p-[50px] md:p-[10px] flex flex-col items-center justify-center"
                >
                    <p class="text-white text-2xl">Profile</p>
                </div>

                <div class="w-full flex md:flex-col gap-0">
                    <div
                        @click="activeTab = n"
                        :class="[
                            activeTab == n
                                ? 'bg-gray-500 text-white'
                                : 'bg-white text-neutral-600',
                        ]"
                        class="text-center md:text-left px-10 py-3 text-lg hover:bg-gray-400 hover:text-white cursor-pointer duration-200"
                        v-for="(r, n) in tabs"
                        :key="n"
                    >
                        {{ r }}
                    </div>
                </div>

                <div
                    class="w-full flex gap-5 flex-wrap md:flex-col px-[40px] pt-[30px] pb-[50px] md:px-[20px] bg-gray-500"
                >
                    <template v-if="activeTab == 0">
                        <div
                            class="w-full flex items-start md:flex-col gap-5 flex-wrap"
                        >
                            <div
                                class="bg-neutral-200 px-10 py-5 rounded-lg space-y-3"
                            >
                                <div class="">
                                    <label for="">Full Name</label>
                                    <input
                                        type="text"
                                        class=""
                                        v-model="profileForm.fullname"
                                    />
                                </div>

                                <div class="">
                                    <label for="">Email</label>
                                    <input
                                        type="text"
                                        class=""
                                        v-model="profileForm.email"
                                    />
                                </div>

                                <div class="">
                                    <label for="">Phone Number</label>
                                    <input
                                        type="text"
                                        class=""
                                        v-model="profileForm.mobile"
                                    />
                                </div>

                                <div class="">
                                    <button
                                        @click="updateProfile"
                                        :class="{
                                            'opacity-25':
                                                profileForm.processing,
                                        }"
                                        :disabled="profileForm.processing"
                                        class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                    >
                                        <p class="">Update Profile</p>
                                    </button>
                                </div>
                            </div>

                            <div
                                class="bg-neutral-200 px-10 py-5 rounded-lg space-y-3"
                            >
                                <div class="">
                                    <label for="">New Password</label>
                                    <input
                                        type="password"
                                        class=""
                                        v-model="passwordForm.password"
                                    />
                                </div>

                                <div class="">
                                    <button
                                        @click="updatePassword"
                                        :class="{
                                            'opacity-25':
                                                passwordForm.processing,
                                        }"
                                        :disabled="passwordForm.processing"
                                        class="bgx-blue rounded-[10px] px-5 py-3 text-white font-semibold inline-flex items-center gap-2"
                                    >
                                        <p class="">Update Password</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-if="activeTab == 1"> </template>

                    <template v-if="activeTab == 2">
                        <div class="w-full px-[150px] md:px-[20px]">
                            <template v-if="favs.length > 0">
                                <div
                                    v-for="r in favs"
                                    :key="r.uuid"
                                    class="w-full"
                                >
                                    <SingleDisplay
                                        :property="r"
                                        :key="r.uuid"
                                    />
                                </div>
                            </template>
                            <template v-else> 
                                <p class="">No Favourites</p>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </Layout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

.discr {
    &::after {
        content: "";
        width: 12px;
        height: 12px;
        background: var(--h-blue-1);
        position: absolute;
        top: 0;
        left: 20px;
        bottom: -12px;
        clip-path: polygon(50% 100%, 0 25%, 100% 25%);
    }
}

input[type="text"],
select {
    transition: all 0.3s;
    width: 100%;
    border-radius: 10px;
    border: 1px solid #aaa;
    outline: none;
    font-size: 1rem;
    box-shadow: none;

    &:focus {
        box-shadow: none;
        border: 1px solid #eee;
    }
}

input[type="checkbox"] {
    background-color: #fff;
    border: 1px solid #aaa;
    height: 13px;
    margin: 0 11px 0 0;
    position: relative;
    width: 13px;

    /* &:checked {
        box-shadow: none;
        border: none;
    } */
}

.tabx {
    color: #1c1c1e;
    padding: 10px 20px;
    background-color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    font-weight: bold;

    &:first-child {
        border-top-left-radius: 20px;
    }

    &:last-child {
        border-top-right-radius: 20px;
    }

    &:hover {
        color: var(--h-blue-1);
        background-color: rgba(255, 255, 255, 0.9);
    }

    &.active {
        background-color: rgba(255, 255, 255, 0.9);
    }
}

.home-card {
    background: linear-gradient(
            to bottom,
            rgba(28, 28, 30, 0.5),
            rgba(28, 28, 30, 0.9)
        ),
        url("@/assets/img/home2.jpg");
    background-size: cover;
}
</style>
