<script setup>
import { onMounted, computed } from "vue";
import { mdiCubeOutline } from "@mdi/js";

import ActionDropDown from "@/Components/Tables/ActionDropDown.vue";

const props = defineProps({
    rawRecords: {
        type: Object,
        default: {},
    },
    excludeColumn: {
        type: Object,
        default: [],
    },
    hideActions: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(["actionClicked"]);

const headerData = computed(() => {
    if (props.rawRecords.length > 0) {
        const columnKeys = Object.keys(props.rawRecords[0].data);
        return columnKeys.filter((item) => {
            return !props.excludeColumn.includes(item);
        });
    } else {
        return [];
    }
});

const bodyData = computed(() => {
    if (props.rawRecords.length > 0) {
        return Object.values(props.rawRecords).map((el) => {
            const columnKeys = Object.keys(el.data);
            const rValues = [];
            columnKeys.forEach((item) => {
                if (!props.excludeColumn.includes(item)) {
                    rValues.push(el.data[item]);
                }
            });
            return rValues;
        });
    } else {
        return [];
    }
});

const actionsData = computed(() => {
    if (props.rawRecords.length > 0) {
        return props.rawRecords.map((item) => {
            return item.actions;
        });
    } else {
        return [];
    }
});

const actionClick = (e, rowIndex) => {
    const rawRecord = props.rawRecords[rowIndex].data;
    const payload = {
        actionType: e,
        data: rawRecord,
        rowIndex: rowIndex
    };

    emit("actionClicked", payload);
};

onMounted(() => {});
</script>

<template>
    <div class="table-wrapper">
        <div
            class="relative bg-white w-full overflow-scroll flex flex-col shadow-md sm:rounded-lg"
        >
            <slot name="tabletop"></slot>
            <table
                v-if="bodyData.length > 0"
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead class="text-sm uppercase">
                    <tr class="border-[#eee] border-b-[1px] bg-white">
                       
                        <th
                            scope="col"
                            class="px-6 py-3"
                            @click="emit('actionClicked', 'id 3')"
                            v-if="!$props.hideActions"
                        >
                            Actions
                        </th>

                        <th
                            class="px-6 py-3"
                            v-for="(th, key) in headerData"
                            :key="key"
                        >
                            {{ th }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b hover:bg-gray-50 text-[#172439] text-base"
                        v-for="(tr, trkey) in bodyData"
                        :key="trkey"
                    >
                        <td
                            class="px-6 py-4 relative"
                            v-if="!$props.hideActions"
                        >
                            <ActionDropDown
                                :actions="actionsData[trkey]"
                                @actionClicked="actionClick($event, trkey)"
                            />
                        </td>

                        <td
                            v-for="(td, key) in tr"
                            :key="key"
                            class="px-6 py-4"
                        >
                            <template v-if="typeof td == 'object'">
                                <span :class="td.class">
                                    {{ td.value }}
                                </span>
                            </template>
                            <template v-else>
                                {{ td }}
                            </template>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="text-sm uppercase">
                    <tr class="border-[#eee] border-b-[1px] bg-white">
                        <th scope="col" class="px-6 py-3 text-black">
                            Actions
                        </th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-black"
                            v-for="(th, key) in headerData"
                            :key="key"
                        >
                            {{ th }}
                        </th>
                    </tr>
                </tfoot>
            </table>
            <div
                v-else
                class="w-full py-[50px] gap-[20px] flex flex-col text-xl justify-center items-center"
            >
                <svg-icon
                    type="mdi"
                    size="50"
                    :path="mdiCubeOutline"
                ></svg-icon>
                <p class="text-[2rem]">No Records</p>
            </div>
            <div
                v-if="bodyData.length > 0"
                class="p-3 flex items-center md:flex-col md:gap-4 justify-between z-[200]"
            >
                <div class="heading">
                    <slot name="recordsummary"></slot>
                </div>
                <div class="pagination-list">
                    <slot name="pagination"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "@/assets/scss/basic.scss";

table {
    thead {
        color: var(--blue-one);
    }
}
</style>
