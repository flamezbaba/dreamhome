<script setup>
import { onMounted, ref } from "vue";
import { mdiChevronDown, mdiChevronRight, mdiCircleMedium } from "@mdi/js";

defineProps({
    hasSubMenu: {
        type: Boolean,
        default: false,
    },
    active: {
        type: Boolean,
        default: false,
    },
    subMenu: {
        type: Object,
        default: {},
    },
    topLinkTitle: {
        type: String,
        default: "",
    },
    topLinkUrl: {
        type: String,
        default: "",
    },
});

onMounted(() => {});

const dropDownOpen = ref(false);
</script>

<template>
    <div class="menu-link" :class="{ active: active }">
        <div class="link-wrapper">
            <Link :href="topLinkUrl" class="sideone">
                <slot name="svg"></slot>
                <span>{{ topLinkTitle }}</span>
            </Link>
            <div
                class="sidetwo"
                v-if="hasSubMenu"
                @click="dropDownOpen = !dropDownOpen"
            >
                <svg-icon
                    type="mdi"
                    :path="mdiChevronDown"
                    v-if="dropDownOpen"
                    size="20"
                ></svg-icon>
                <svg-icon
                    type="mdi"
                    :path="mdiChevronRight"
                    size="20"
                    v-else
                ></svg-icon>
            </div>
        </div>
        <div
            class="dropdown-wrapper"
            v-if="(hasSubMenu && dropDownOpen) || (hasSubMenu && active)"
        >
            <Link
                :href="r.link"
                class="sub-link"
                v-for="(r, i) in subMenu"
                :key="i"
            >
                <svg-icon
                    type="mdi"
                    size="18"
                    :path="mdiCircleMedium"
                ></svg-icon>
                <span>{{ r.title }}</span>
            </Link>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";
.menu-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;

    &:hover {
        background-color: #0f1725;
    }

    &.active {
        background-color:#0f1725;
    }

    .link-wrapper {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        transition: all 0.3s;

        .sideone {
            display: flex;
            gap: 8px;
            align-items: center;
        }
    }

    .dropdown-wrapper {
        width: 100%;
        padding-top: 0px;
        padding-bottom: 10px;

        .sub-link {
            padding-left: 15px;
            padding-bottom: 10px;
            display: flex;
            align-items: center;

            &:hover {
                text-decoration: underline;
            }
        }
    }
}
</style>
