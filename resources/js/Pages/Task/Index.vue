<template>
    <div class="mx-10 mt-10">
        <h1 class="text-2xl font-bold mb-4">Task List</h1>

        <div class="pb-4">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="openModal('create')"
            >
                Create Task
            </button>
        </div>

        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-slate-400">
                <tr>
                    <th class="py-2 px-4 border-b">Title</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Deadline</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Course</th>
                    <th class="py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id">
                    <td class="py-2 px-4 border-b max-w-[150px]">
                        {{ item.title }}
                    </td>
                    <td class="py-2 px-4 border-b max-w-[200px] break-words">
                        {{ item.description }}
                    </td>
                    <td class="py-2 px-4 border-b max-w-[100px] text-center">
                        {{ formatDateTime(item.deadline) }}
                    </td>
                    <!-- <td class="py-2 px-4 border-b max-w-[100px] text-center">{{ item.deadline }}</td> -->
                    <td class="py-2 px-4 border-b text-center">
                        {{ item.status }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ item.course }}
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div
                            class="flex flex-wrap gap-1 items-center justify-center"
                        >
                            <button @click="openEditModal(item)">
                                <img
                                    width="28"
                                    height="28"
                                    src="https://img.icons8.com/pastel-glyph/64/create-new--v1.png"
                                    alt="create-new--v1"
                                />
                            </button>
                            <button @click="deleteTask(item.id)">
                                <img
                                    width="32"
                                    height="32"
                                    src="https://img.icons8.com/sf-regular-filled/48/trash.png"
                                    alt="trash"
                                />
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal :show="modalVisible" @close="closeModal">
            <div v-if="modalType === 'create'">
                <h1 class="text-2xl font-bold mb-4">Create Task</h1>
                <form @submit.prevent="createTask">
                    <div class="mb-4">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Title:</label
                        >
                        <input
                            v-model="formData.title"
                            type="text"
                            id="title"
                            name="title"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >Description:</label
                        >
                        <textarea
                            v-model="formData.description"
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 p-2 border rounded-md w-full"
                        ></textarea>
                    </div>

                    <div class="mb-4">
                        <label
                            for="deadline"
                            class="block text-sm font-medium text-gray-700"
                            >Deadline:</label
                        >
                        <input
                            v-model="formData.deadline"
                            type="datetime-local"
                            id="deadline"
                            name="deadline"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700"
                            >Status:</label
                        >
                        <input
                            v-model="formData.status"
                            type="text"
                            id="status"
                            name="status"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="course"
                            class="block text-sm font-medium text-gray-700"
                            >Course:</label
                        >
                        <input
                            v-model="formData.course"
                            type="text"
                            id="course"
                            name="course"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded"
                        >
                            Save Task
                        </button>
                    </div>
                </form>
            </div>

            <div v-else-if="modalType === 'edit'">
                <h1 class="text-2xl font-bold mb-4">Update Task</h1>
                <form @submit.prevent="updateTask(taskEdit)">
                    <div class="mb-4">
                        <label
                            for="title"
                            class="block text-sm font-medium text-gray-700"
                            >Title:</label
                        >
                        <input
                            v-model="formData.title"
                            type="text"
                            id="title"
                            name="title"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >Description:</label
                        >
                        <textarea
                            v-model="formData.description"
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 p-2 border rounded-md w-full"
                        ></textarea>
                    </div>

                    <div class="mb-4">
                        <label
                            for="deadline"
                            class="block text-sm font-medium text-gray-700"
                            >Deadline:</label
                        >
                        <input
                            v-model="formData.deadline"
                            type="datetime-local"
                            id="deadline"
                            name="deadline"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700"
                            >Status:</label
                        >
                        <input
                            v-model="formData.status"
                            type="text"
                            id="status"
                            name="status"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <div class="mb-4">
                        <label
                            for="course"
                            class="block text-sm font-medium text-gray-700"
                            >Course:</label
                        >
                        <input
                            v-model="formData.course"
                            type="text"
                            id="course"
                            name="course"
                            class="mt-1 p-2 border rounded-md w-full"
                        />
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-500 text-white font-bold py-2 px-4 rounded"
                    >
                        Update Task
                    </button>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import Modal from "../../Components/Modal.vue";
import { router } from "@inertiajs/vue3";

const { data } = defineProps(["data"]);
const modalType = ref("");
const modalVisible = ref(false);
const taskEdit = ref(null);

const initialValue = {
    title: "",
    description: "",
    deadline: "",
    status: "",
    course: "",
};

let formData = reactive({
    title: "",
    description: "",
    deadline: "",
    status: "",
    course: "",
});

const formatDateTime = (dateTimeString) => {
    const options = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    const formattedDateTime = new Date(dateTimeString).toLocaleDateString(
        "en-GB",
        options
    );
    return formattedDateTime.replace(",", "");
};

const openEditModal = (item) => {
    taskEdit.value = item.id;
    formData.title = item.title;
    formData.description = item.description;
    formData.deadline = item.deadline;
    formData.status = item.status;
    formData.course = item.course;

    openModal("edit");
};

const openModal = (type) => {
    modalType.value = type;
    modalVisible.value = true;
};

const closeModal = () => {
    formData = initialValue;
    modalType.value = "";
    modalVisible.value = false;
};

const createTask = () => {
    router.post("/task", formData);
    closeModal();
};

const updateTask = (id) => {
    console.log(formData.deadline);
    formData.id = id;

    console.log(`Update item with id ${id}`);
    console.log("ID dari formData: ", formData.id);

    openModal("edit");
    router.put(`/task/${formData.id}`, formData);
    closeModal();
};

const deleteTask = (id) => {
    if (confirm("Are you sure you want to delete this task?")) {
        console.log(`Delete item with id ${id}`);
        router.delete(`/task/${id}`);
    }
};
</script>
