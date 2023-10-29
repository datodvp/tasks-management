<script setup>
import { ref, watch, provide } from "vue";
import { router, Link } from "@inertiajs/vue3";
import EmployeeForm from "../Shared/EmployeeForm.vue";
import TasksTable from "../Shared/Tables/TasksTable.vue";
import { sumTimes } from "../Utils/sumTimes";

const props = defineProps({
    data: Object,
});

const selectedEmployeeId = ref(
    props.data?.selected_employee_id || props.data?.employeesList[0]?.id
);
const selectedDate = ref(
    props.data?.selected_date || new Date().toISOString().slice(0, 10)
);

watch([selectedEmployeeId, selectedDate], ([a, b]) => {
    router.get("/", { selected_employee_id: a, selected_date: b });
});

provide("selectedQueries", {
    selected_employee_id: selectedEmployeeId,
    selected_date: selectedDate,
});

const sumOfPlannedTasksTime = () => {
    let sum = "00:00";
    props.data.tasks_of_week?.forEach((task) => {
        // if task is uplanned we dont sum its time
        if (task.task_type !== "unplanned") {
            sum = sumTimes(sum, task.planned_time || "00:00:00");
        }
    });

    return sum;
};

const sumOfActualTasksTime = () => {
    let sum = "00:00";
    props.data.tasks_of_week?.forEach((task) => {
        // if task is uplanned we dont sum its time
        if (task.task_type !== "unplanned") {
            sum = sumTimes(sum, task.actual_time || "00:00:00");
        }
    });

    return sum;
};
</script>

<template>
    <div class="flex flex-col items-center">
        <div class="flex justify-around w-full">
            <div
                class="flex flex-col items-center w-full p-4 border-b border-black"
            >
                <Link href="/">
                    <h1
                        class="p-4 mb-4 text-white bg-red-500 border rounded-lg hover:bg-red-400"
                    >
                        დაარესტარტე არჩეული პარამეტრები
                    </h1>
                </Link>
                <div class="flex items-center gap-4">
                    <div
                        class="flex flex-col gap-1 p-2 bg-blue-400 border rounded-lg"
                    >
                        <div>
                            <p>აირჩიე თარიღი:</p>
                            <input
                                v-model="selectedDate"
                                type="date"
                                class="p-2 mt-1 border border-black rounded-lg"
                            />
                        </div>
                        <h1 v-if="data" class="mb-2">
                            არჩეული კვირა: {{ data.startDate }} -
                            {{ data.endDate }}
                        </h1>
                        <div>
                            <p class="mb-2">აირჩიე თანამშრომელი:</p>
                            <select
                                v-model="selectedEmployeeId"
                                class="p-2 min-w-[10rem] w-full rounded-lg"
                            >
                                <option
                                    v-for="employee in data.employeesList"
                                    :value="employee.id"
                                >
                                    {{ employee.firstname }}
                                    {{ employee.lastname }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <EmployeeForm />
                </div>
            </div>
        </div>

        <div>
            <TasksTable
                title="ამოცანები პროგრამებისა და პროექტებისთვის"
                table_type="projects"
                :tasks_of_week="data.tasks_of_week"
            />
            <TasksTable
                title="კვოტის მისაღწევად საჭირო ამოცანები"
                table_type="quotes"
                :tasks_of_week="data.tasks_of_week"
            />
            <TasksTable
                title="რეგულარული ამოცანები"
                table_type="regular"
                :tasks_of_week="data.tasks_of_week"
            />
            <TasksTable
                title="ამოცანები ტრენინგებთან მიმართებაში"
                table_type="trainings"
                :tasks_of_week="data.tasks_of_week"
            />
            <div class="flex items-center justify-end px-4 py-2">
                <div
                    class="flex gap-3 p-3 my-2 text-white bg-red-600 border border-l-0 border-black rounded-lg"
                >
                    <div>
                        <p>სულ დაგეგმილი დრო:</p>
                        {{ sumOfPlannedTasksTime() }}
                        <p>სულ ფაქტოური დრო:</p>
                        {{ sumOfActualTasksTime() }}
                    </div>
                </div>
            </div>

            <TasksTable
                title="დაუგეგმავი ამოცანები"
                table_type="unplanned"
                :tasks_of_week="data.tasks_of_week"
            />
        </div>
    </div>
</template>

<style>
body {
    background-color: rgb(229 231 235);
}
</style>
