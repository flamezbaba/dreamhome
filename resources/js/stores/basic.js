import { ref, computed } from "vue";
import { defineStore } from "pinia";

export const useBasicStore = defineStore(
    "basic",
    () => {
        const favs = ref([]);

        function removeFav(uuid) {
            const index = favs.value.indexOf(uuid);
            favs.value.splice(index, 1);
        }

        function addFav(uuid) {
            favs.value.push(uuid);
        }

        function isFav(uuid) {
            return favs.value.includes(uuid);
        }

        function toggleFav(uuid) {
            if (isFav(uuid)) {
                removeFav(uuid);
            } else {
                addFav(uuid);
            }
        }

        return {
            favs,
            addFav,
            removeFav,
            isFav,
            toggleFav,
        };
    },
    {
        persist: true,
    }
);
