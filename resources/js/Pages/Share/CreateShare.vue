<script setup>
import { ref } from "vue";

const selectedUsers = ref([
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
]);
const users = ref([
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
    "Jhoan Sebastian Duque Vera",
]);

const addUser = (user) => {
    if (!selectedUsers.value.includes(user)) {
        selectedUsers.value.push(user);
    }
};

const removeUser = (index) => {
    selectedUsers.value.splice(index, 1);
};
</script>

<template>
    <div
        class="max-w-lg mx-auto mt-10 bg-white shadow-md rounded-lg overflow-hidden"
    >
        <div class="custom-bg text-white p-4 text-center">Compartir</div>
        <div class="p-4 border-b border-gray-300">
            <div
                class="flex items-center border border-gray-400 rounded-md p-2"
            >
                <div class="flex-grow flex flex-wrap">
                    <div
                        v-for="(selected, index) in selectedUsers"
                        :key="index"
                        class="flex items-center bg-gray-200 text-gray-800 rounded-full px-3 py-1 m-1"
                    >
                        <span class="nombre">{{ selected }}</span>
                        <button
                            @click="removeUser(index)"
                            class="ml-2 text-gray-600"
                        >
                            x
                        </button>
                    </div>
                </div>
                <button class="ml-2 text-gray-600">
                    <img src="/assets/images/Group-722.png" />
                </button>
            </div>
        </div>
        <div class="p-4">
            <ul>
                <li
                    v-for="(user, index) in users"
                    :key="index"
                    class="flex items-center justify-between mb-4"
                >
                    <div class="flex items-center">
                        <div class="w-12 h-10 flex items-center justify-center">
                            <img src="/assets/images/component3.png" />
                        </div>
                        <span class="color ml-4 text-gray-800">{{ user }}</span>
                    </div>
                    <button
                        @click="addUser(user)"
                        class="text-white rounded-full w-8 h-8 flex items-center justify-center"
                    >
                        <img src="/assets/images/Group-375.png" />
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.bg-blue-900 {
    background-color: #1e3a8a;
}

.custom-bg {
    background-color: #00324d;
    border-radius: 5px;
}

.color {
    color: #00324d;
    font-size: 20px;
}

.nombre {
    color: #00324d;
}
</style>
