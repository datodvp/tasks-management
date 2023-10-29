<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { sumTimes } from "../../Utils/sumTimes.js";
import TaskForm from "../TaskForm.vue";
import EditTaskForm from "../EditTaskForm.vue";

const props = defineProps({
    title: String,
    table_type: String,
    tasks_of_week: Array,
});

const openTaskForm = ref(false);
const openEditTaskForm = ref(false);
const editingTask = ref(null);

const actualTimeSum = () => {
    let sum = "00:00";
    props.tasks_of_week?.forEach((task) => {
        if (task.task_type === props.table_type) {
            sum = sumTimes(sum, task.actual_time || "00:00:00");
        }
    });

    return sum;
};

const plannedTimeSum = () => {
    let sum = "00:00";
    props.tasks_of_week?.forEach((task) => {
        if (task.task_type === props.table_type) {
            sum = sumTimes(sum, task.planned_time || "00:00:00");
        }
    });

    return sum;
};

const toggleTaskForm = () => {
    openTaskForm.value = !openTaskForm.value;
};

const toggleEditTaskForm = (task) => {
    editingTask.value = task;
    openEditTaskForm.value = !openEditTaskForm.value;
};
</script>

<template>
    <div>
        <template v-if="openTaskForm">
            <TaskForm
                :table_type="table_type"
                :toggleTaskForm="toggleTaskForm"
            />
        </template>

        <template v-if="openEditTaskForm">
            <EditTaskForm
                :task="editingTask"
                :toggleEditTaskForm="toggleEditTaskForm"
            />
        </template>

        <div class="py-2 mx-4 border">
            <table class="w-full table-fixed">
                <thead>
                    <tr>
                        <th class="p-2 bg-blue-500 rounded-lg">
                            {{ title }}
                        </th>
                        <th class="bg-blue-500 rounded-lg">
                            ამოცანის პროდუქტი
                        </th>
                        <th
                            v-if="table_type !== 'unplanned'"
                            class="bg-blue-500 rounded-lg"
                        >
                            დაგეგმილი დრო
                        </th>
                        <th class="bg-blue-500 rounded-lg">ფაქტიური დრო</th>
                        <th class="bg-blue-500 rounded-lg">
                            შესრულების თარიღი
                        </th>
                        <th class="bg-blue-500 rounded-lg">წაშლა</th>
                    </tr>
                </thead>
                <tbody v-for="task in props.tasks_of_week">
                    <tr v-if="task.task_type === table_type">
                        <td class="break-words bg-white border rounded-lg">
                            {{ task.task_name }}
                        </td>
                        <td class="break-words bg-white border rounded-lg">
                            {{ task.task_product }}
                        </td>
                        <td
                            v-if="table_type !== 'unplanned'"
                            class="break-words bg-white border rounded-lg"
                        >
                            {{ task.planned_time }}
                        </td>
                        <td class="break-words bg-white border rounded-lg">
                            {{ task.actual_time }}
                        </td>
                        <td class="break-words bg-white border rounded-lg">
                            {{ task.completion_time }}
                        </td>
                        <td class="bg-white border rounded-lg">
                            <div class="flex justify-around">
                                <button
                                    @click="toggleEditTaskForm(task)"
                                    class="px-2 py-1 text-white bg-blue-500"
                                >
                                    შეცვლა
                                </button>
                                <button
                                    @click="router.delete(`/tasks/${task.id}`)"
                                    class="px-2 py-1 text-white bg-red-500"
                                >
                                    წაშლა
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <button
                    @click="toggleTaskForm"
                    class="px-3 py-1 text-2xl border border-red-600 rounded-lg"
                >
                    +
                </button>
            </table>
            <div
                v-if="
                    plannedTimeSum() !== '00:00' || actualTimeSum() !== '00:00'
                "
                class="flex ml-auto w-fit mt-[-3rem]"
            >
                <div
                    v-if="table_type !== 'unplanned'"
                    class="flex gap-3 px-4 py-2 my-2 bg-pink-400 border border-black rounded-lg"
                >
                    <p>დაგეგმილი ჯამური დრო:</p>
                    <div>{{ plannedTimeSum() }}</div>
                </div>
                <div
                    class="flex gap-3 px-4 py-2 my-2 bg-pink-400 border border-black rounded-lg"
                >
                    <p>ფაქტიური ჯამური დრო:</p>
                    <div>{{ actualTimeSum() }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
