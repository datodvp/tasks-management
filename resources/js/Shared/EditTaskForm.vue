<script setup>
import { watch, onMounted, inject, onUnmounted } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    selectedEmployeeId: Number,
    selectedDate: String,
    toggleEditTaskForm: Function,
    table_type: String,
    task: Object,
});

const selectedQueries = inject("selectedQueries");

let taskForm = useForm({
    task_type: props.task.task_type,
    task_name: props.task.task_name,
    task_product: props.task.task_product,
    planned_time: props.task.planned_time,
    actual_time: props.task.actual_time,
    completion_time: props.task.completion_time,
    selected_date: selectedQueries.selected_date?.value,
    selected_employee_id: selectedQueries.selected_employee_id?.value,
});

watch(props, (newProps) => {
    taskForm.selected_employee_id = newProps.selectedEmployeeId;
    taskForm.selected_date = newProps.selectedDate;
});

onMounted(() => {
    // hide scroll
    document.body.style.overflow = "hidden";
});

onUnmounted(() => {
    // remove hidden scroll on unmount
    document.body.style.overflow = "auto";
});
</script>

<template>
    <div
        class="fixed w-[100vw] h-[100vh] top-0 bottom-0 left-0 right-0 bg-black bg-opacity-80 flex items-center justify-center"
    >
        <div class="w-full h-full" @click="toggleEditTaskForm()"></div>
        <div class="absolute w-1/2">
            <form
                @submit.prevent="submitTask"
                class="relative w-full p-4 bg-gray-400 border rounded-lg min-w-fit"
            >
                <button
                    class="absolute text-lg font-medium cursor-pointer right-10 hover:font-black"
                    type="button"
                    @click="toggleEditTaskForm()"
                >
                    X
                </button>
                <h1 class="mb-4 text-lg font-bold">შეცვალე ამოცანა:</h1>

                <div class="flex flex-col">
                    <label class="p-2 border border-black">
                        ამოცანის სახელი:
                        <input
                            v-model="taskForm.task_name"
                            type="text"
                            placeholder="ტექსტი..."
                            class="w-full max-w-[30rem] bg-transparent outline-none"
                        />
                        <p class="text-red-600">
                            {{ taskForm.errors.task_name }}
                        </p>
                    </label>
                    <label class="p-2 border border-black">
                        ამოცანის პროდუქტი:
                        <input
                            v-model="taskForm.task_product"
                            type="text"
                            placeholder="ამოცანის პროდუქტი"
                            class="w-full max-w-[30rem] bg-transparent outline-none"
                        />
                        <p class="text-red-600">
                            {{ taskForm.errors.task_product }}
                        </p>
                    </label>

                    <label class="p-2 border border-black">
                        დაგეგმილი დრო:
                        <input
                            v-model="taskForm.planned_time"
                            type="time"
                            placeholder="დაგეგმილი დრო 00:00"
                        />
                    </label>
                    <p class="text-red-600">
                        {{ taskForm.errors.planned_time }}
                    </p>

                    <label class="p-2 border border-black">
                        ფაქტიური დრო:
                        <input
                            v-model="taskForm.actual_time"
                            type="time"
                            placeholder="ფაქტიური დრო 00:00"
                        />
                    </label>
                    <p class="text-red-600">
                        {{ taskForm.errors.actual_time }}
                    </p>
                    <label class="p-2 border border-black">
                        დასრულების თარიღი:
                        <input
                            v-model="taskForm.completion_time"
                            type="date"
                            placeholder="დასრულების დრო"
                        />
                        <p class="text-red-600">
                            {{ taskForm.errors.completion_time }}
                        </p>
                    </label>

                    <p class="p-1 text-red-600">
                        {{
                            taskForm.errors.selected_employee_id &&
                            "შექმენით/აირჩიეთ თანამშრომელი"
                        }}
                    </p>
                </div>

                <button
                    @click="
                        () => {
                            taskForm.put(`/tasks/${task.id}`, {
                                preserveScroll: true,
                                onSuccess: () => toggleEditTaskForm(),
                            });
                        }
                    "
                    class="p-2 border border-black"
                >
                    შეცვლა
                </button>
            </form>
        </div>
    </div>
</template>
