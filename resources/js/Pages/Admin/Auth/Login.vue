<script setup>
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/Form/InputError.vue";
import FlashMessages from "@/Components/Form/FlashMessages.vue";

defineProps({
    page_title: String,
});

const form = useForm({
    email: "",
    password: "",
    login: true,
});

const submit = () => {
    form.post(route("admin.login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <div class="page-wrapper">
        <Head :title="page_title" />
        <div class="body-bg"></div>
        <div class="content-wrapper">
            <form autocomplete="on"
                class="login md:w-[90%] w-[35%] flex justify-start items-start flex-col"
                @submit.prevent="submit"
            >
                <p class="text-xl">Welcome Back!</p>
                <div class="w-full mt-2">
                    <FlashMessages />
                </div>

                <div class="form-group w-full">
                    <label for="">Email Address</label>
                    <input
                        type="text"
                        v-model="form.email"
                        name="text"
                        class="form-control"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>
                <div class="form-group mt-5 w-full">
                    <label for="">Password</label>
                    <input
                        type="password"
                        v-model="form.password"
                        name="password"
                        class="form-control"
                    />
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>

                <div class="form-group mt-5">
                    <button
                        type="submit"
                        name="login"
                        class="btn btn-blue rounded-lg font-[600] px-[40px] py-[10px]"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
.page-wrapper {
    width: 100%;
    min-height: 100vh;
    position: relative;

    .body-bg {
        background: url("@/assets/img/bg1.jpg");
        background-size: contain;
        filter: blur(2px);
        border: none;
        height: 100vh;
    }

    .content-wrapper {
        width: 100%;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 0;
        left: 0;

        .login {
            height: auto;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 5px 0 rgba(39, 38, 38, 0.4);
            padding: 20px;
        }
    }
}
</style>
