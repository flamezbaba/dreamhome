<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";
import basicUtil from "@/Utils/basic.js";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
// import { SourceEditing } from "@ckeditor/ckeditor5-source-editing";

const props = defineProps({
    page_title: String,
    types: Object | Array,
    property: Object,
    categories: Object | Array,
    currency: Object | Array,
});

const editor = ClassicEditor;
const openTabs = ref({ basic: true, pictures: true, specs: true, video: true });
const modals = ref({ spec: false, picture: null, video: null });
const spec = ref({ name: null, value: null });
const pic = ref({ image: null, preview: null });

const picForm = useForm({
    upload_image: true,
    image: null,
});

const deletePicForm = useForm({
    delete_image: true,
    image: null,
});

const vidForm = useForm({
    upload_video: true,
    vid: null,
});

const deleteVidForm = useForm({
    delete_video: true,
    vid: null,
});

const form = useForm({
    edit_property: true,
    title: props.property?.title,
    address: props.property?.address,
    category: props.property?.category,
    type: props.property?.type,
    price: props.property?.price,
    price_suffix: props.property?.price_suffix,
    description: props.property.description || "",
    pictures: props.property?.pictures,
    videos: props.property?.videos,
    bedrooms: props.property?.bedrooms,
    toilets: props.property?.toilets,
    bathrooms: props.property?.bathrooms,
    currency_id: props.property?.currency_id,
    parking_space: props.property?.parking_space,
    state: props.property?.state,
    city: props.property?.city,
    bonus: props.property?.bonus,
    specs: props.property?.features,
});

const confirmModalReturns = () => { };

function createSpec() {
    form.specs.push({ name: spec.value.name, value: spec.value.value });
    spec.value.name = null;
    spec.value.value = null;
    modals.value.spec = false;
}

function deleteSpec(index) {
    if (confirm("Are you sure?")) {
        form.specs.splice(index, 1);
    }
}

function addPicture(ev) {
    const image = ev.target.files[0];

    const reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = (e) => {
        pic.value.image = image;
        pic.value.preview = e.target.result;
    };
}

function submitImage() {
    if (pic.value.image) {
        picForm.image = pic.value.image;
        picForm.post(window.location.toString(), {
            preserveScroll: true,
            onSuccess: () => {
                picForm.reset();
                pic.value.image = null;
                pic.value.preview = null;
            },
        });

        modals.value.picture = false;
    }
}

function deletePicture(index) {
    const cn = confirm("Are you sure?");
    if (cn) {
        deletePicForm.image = props.property.pictures[index];
        deletePicForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }
}

function addVideo(ev) {
    vidForm.vid = ev.target.files[0];
}

function submitVideo() {
    vidForm.post(window.location.toString(), {
        preserveScroll: true,
        onSuccess: () => {
            vidForm.reset();
        },
    });

    modals.value.video = false;
}

function deleteVideo(index) {
    const cn = confirm("Are you sure?");
    if (cn) {
        deleteVidForm.vid = props.property.videos[index];
        deleteVidForm.post(window.location.toString(), {
            preserveScroll: true,
            preserveState: true,
        });
    }
}

function handleSubmit() {

    form.post(window.location.toString(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // openModal.value.balance = false;
        },
    });
}

onMounted(() => { });

import { mdiPlus, mdiClose, mdiChevronDown, mdiChevronUp } from "@mdi/js";
import Datepicker from "vue3-datepicker";
import Multiselect from "@vueform/multiselect";

import AdminLayout from "@/Layouts/Admin.vue";
import DefaultModal from "@/Components/Modals/Default.vue";
</script>

<template>
    <AdminLayout :title="page_title" @onModalActionTwo="confirmModalReturns">
        <template #page-modal>
            <DefaultModal :show="modals.spec">
                <template #modal-content>
                    <div class="w-full">
                        <div class="w-full flex justify-between items-center px-[20px] py-[10px]">
                            <p class="text-lg">Create Features</p>
                            <svg-icon @click="modals.spec = false" type="mdi" :size="20" :path="mdiClose"
                                class="cursor-pointer"></svg-icon>
                        </div>
                        <div class="w-full flex justify-between items-center px-[20px] pb-[20px] mt-[2px]">
                            <form class="w-full" @submit.prevent="createSpec" autocomplete="on">
                                <div class="w-full flex md:flex-col justify-center gap-6 md:gap-1">
                                    <div class="w-6/12 md:w-full">
                                        <div class="form-group mt-2">
                                            <label class="">Name</label>
                                            <input type="text" :autocomplete="true" class="form-control"
                                                v-model="spec.name" />
                                        </div>
                                    </div>
                                    <div class="w-6/12 md:w-full">
                                        <div class="form-group mt-2">
                                            <label class="">Value</label>
                                            <input type="text" class="form-control" v-model="spec.value" />
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-blue">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </DefaultModal>
            <DefaultModal :show="modals.picture">
                <template #modal-content>
                    <div class="w-full">
                        <div class="w-full flex justify-between items-center px-[20px] py-[10px]">
                            <p class="text-lg">Add Picture</p>
                            <svg-icon @click="modals.picture = false" type="mdi" :size="20" :path="mdiClose"
                                class="cursor-pointer"></svg-icon>
                        </div>
                        <div class="w-full flex justify-between items-center px-[20px] pb-[20px] mt-[2px]">
                            <form class="w-full" @submit.prevent="submitImage" autocomplete="on"
                                enctype="multipart/form-data">
                                <div class="w-full flex flex-col gap-3 md:gap-1">
                                    <div class="w-6/12 md:w-full">
                                        <div class="form-group mt-2">
                                            <label class="">Select Image</label>
                                            <input type="file" class="form-control" accept="image/*"
                                                @input="addPicture($event)" />
                                        </div>
                                        <img v-if="pic.preview" :src="pic.preview" class="w-[150px]" alt="mt-3" />
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-blue">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </DefaultModal>
            <DefaultModal :show="modals.video">
                <template #modal-content>
                    <div class="w-full">
                        <div class="w-full flex justify-between items-center px-[20px] py-[10px]">
                            <p class="text-lg">Add Video</p>
                            <svg-icon @click="modals.video = false" type="mdi" :size="20" :path="mdiClose"
                                class="cursor-pointer"></svg-icon>
                        </div>
                        <div class="w-full flex justify-between items-center px-[20px] pb-[20px] mt-[2px]">
                            <form class="w-full" @submit.prevent="submitVideo" autocomplete="on"
                                enctype="multipart/form-data">
                                <div class="w-full flex flex-col gap-3 md:gap-1">
                                    <div class="w-6/12 md:w-full">
                                        <div class="form-group mt-2">
                                            <label class="">Select Video</label>
                                            <input type="file" class="form-control" accept="video/*"
                                                @input="addVideo($event)" />
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-blue">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </DefaultModal>
        </template>
        <template #main-content="contentProps">
            <div class="w-full px-[40px] md:px-[20px] md:py-[20px]">
                <div
                    class="page-top w-full flex md:gap-4 md:flex-col items-center md:items-start justify-between md:justify-start mt-5">
                    <div class="title text-[2rem] font-bold capitalize">
                        {{ page_title }}
                    </div>

                    <div class=""></div>
                </div>
                <div class="page-content w-full flex flex-col items-start mb-[200px]">
                    <form @submit.prevent="handleSubmit" class="w-full">
                        <div class="w-full mt-[10px] bg-white">
                            <div class="flex justify-between items-center w-full bgx-blue text-white py-2 px-4">
                                <div class="">
                                    <p class="text-lg font-semibold">ID: {{ props.property.uuid }}</p>
                                </div>
                                <div class="cursor-pointer" @click="openTabs.basic = !openTabs.basic">
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronUp"
                                        v-if="openTabs.basic"></svg-icon>
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronDown" v-else></svg-icon>
                                </div>
                            </div>

                            <div class="flex flex-col justify-between items-center w-full p-4" v-if="openTabs.basic">
                                <div class="w-full flex flex-wrap">
                                    <div class="w-6/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">Title
                                            </label>
                                            <input required v-model="form.title" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">Type
                                            </label>

                                            <select required v-model="form.type" class="capitalize">
                                                <option :value="r.name" class="" v-for="r in types">
                                                    {{ r.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">Category
                                            </label>
                                            <select required v-model="form.category" class="capitalize">
                                                <option :value="r.name" class="" v-for="r in categories">
                                                    {{ r.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full flex flex-wrap" v-if="form.type != 'land'">
                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Bedrooms
                                            </label>
                                            <input v-model="form.bedrooms" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Toilets
                                            </label>
                                            <input v-model="form.toilets" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Bathrooms
                                            </label>
                                            <input v-model="form.bathrooms" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Parking Space
                                            </label>
                                            <input v-model="form.parking_space" type="text" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full flex flex-wrap">
                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">Currency
                                            </label>
                                            <select required v-model="form.currency_id" class="capitalize">
                                                <option :value="r.id" class="" v-for="r in currency">
                                                    {{ r.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">Price
                                            </label>
                                            <input required v-model="form.price" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Price Suffix
                                            </label>
                                            <input v-model="form.price_suffix" type="text" class="form-control" />
                                            <p class="">e.g per annum</p>
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Bonus Percentage
                                            </label>
                                            <input v-model="form.bonus" type="text" class="form-control" />
                                            <p class="">Numbers only 0 - 100</p>
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">City
                                            </label>
                                            <input required v-model="form.city" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-3/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="imp">State
                                            </label>
                                            <input required v-model="form.state" type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="w-6/12 md:w-full pb-4 pr-8">
                                        <div class="form-group">
                                            <label for="" class="">Full Address
                                            </label>
                                            <textarea v-model="form.address" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full flex flex-wrap">
                                    <div class="w-full pb-4 pr-8">
                                        <div class="">
                                            <label for="" class="">Property Description
                                            </label>
                                            <ckeditor class="w-full" :editor="editor" v-model="form.description">
                                            </ckeditor>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-[10px] bg-white">
                            <div class="flex justify-between items-center w-full bgx-blue text-white py-2 px-4">
                                <div class="">
                                    <p class="text-lg font-semibold">
                                        Features
                                    </p>
                                </div>
                                <div class="cursor-pointer" @click="openTabs.specs = !openTabs.specs">
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronUp"
                                        v-if="openTabs.specs"></svg-icon>
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronDown" v-else></svg-icon>
                                </div>
                            </div>

                            <div class="w-full p-4" v-if="openTabs.specs">
                                <button type="button" class="btn btn-blue" @click="modals.spec = true">
                                    Create Features
                                </button>
                                <div class="w-full mt-5">
                                    <table class="plain-table w-[50%]">
                                        <thead>
                                            <tr>
                                                <th>Feature Name</th>
                                                <th>Value</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(r, n) in form.specs" :key="n">
                                                <td>{{ r.name }}</td>
                                                <td>{{ r.value }}</td>
                                                <td>
                                                    <button @click.prevent="
        deleteSpec(n)
        ">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-[10px] bg-white">
                            <div class="flex justify-between items-center w-full bgx-blue text-white py-2 px-4">
                                <div class="">
                                    <p class="text-lg font-semibold">
                                        Pictures
                                    </p>
                                </div>
                                <div class="cursor-pointer" @click="
        openTabs.pictures = !openTabs.pictures
        ">
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronUp"
                                        v-if="openTabs.pictures"></svg-icon>
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronDown" v-else></svg-icon>
                                </div>
                            </div>

                            <div class="w-full p-4" v-if="openTabs.pictures">
                                <div class="w-full mt-5">
                                    <button class="btn btn-blue" type="button" @click="modals.picture = true">
                                        Upload Image
                                    </button>

                                    <div class="w-full flex flex-wrap gap-8 mt-4">
                                        <div class="relative" v-for="(r, n) in props.property
        .images" :key="n">
                                            <img :src="r" class="w-[150px]" alt="" />

                                            <svg-icon @click="deletePicture(n)"
                                                class="absolute top-[-15px] right-[-14px] text-red-500 drop-shadow-md cursor-pointer"
                                                type="mdi" :size="35" :path="mdiClose"></svg-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-[10px] bg-white">
                            <div class="flex justify-between items-center w-full bgx-blue text-white py-2 px-4">
                                <div class="">
                                    <p class="text-lg font-semibold">Videos</p>
                                </div>
                                <div class="cursor-pointer" @click="openTabs.video = !openTabs.video">
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronUp"
                                        v-if="openTabs.video"></svg-icon>
                                    <svg-icon type="mdi" :size="20" :path="mdiChevronDown" v-else></svg-icon>
                                </div>
                            </div>

                            <div class="w-full p-4" v-if="openTabs.video">
                                <div class="w-full mt-5">
                                    <button type="button" class="btn btn-blue" @click="modals.video = true">
                                        Upload Video
                                    </button>

                                    <div class="w-full flex flex-wrap gap-8 mt-4">
                                        <div class="relative" v-for="(r, n) in props.property
        .vids" :key="n">
                                            <video :src="r" class="w-[350px]" alt="" controls></video>

                                            <svg-icon @click="deleteVideo(n)"
                                                class="absolute top-[-15px] right-[-14px] text-red-500 drop-shadow-md cursor-pointer"
                                                type="mdi" :size="35" :path="mdiClose"></svg-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-5">
                            <button class="btn btn-blue" type="submit" :class="{
        'opacity-25': form.processing,
    }" :disabled="form.processing">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
