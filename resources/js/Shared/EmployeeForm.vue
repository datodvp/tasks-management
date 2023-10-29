<script setup>
import { reactive, ref } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";
import EmployeeForm from "../Shared/EmployeeForm.vue";
import axios from "axios";

let employeeForm = useForm({
    firstname: "",
    lastname: "",
});

const successMessage = ref("");

const submit = () => {
    employeeForm.post("/employees", {
        onSuccess: () => {
            employeeForm.reset();
            successMessage.value = "თანამშრომელი დაემატა";
            setTimeout(() => {
                successMessage.value = "";
            }, 1000);
        },
    });
};
</script>

<template>
    <div class="p-1 bg-blue-400 border rounded-lg max-w-[18rem] w-[18rem]">
        <form @submit.prevent="submit" class="flex flex-col">
            <h1>დაამატე ახალი თანამშრომელი:</h1>
            <div class="flex flex-col">
                <input
                    v-model="employeeForm.firstname"
                    type="text"
                    placeholder="სახელი"
                    class="p-2 text-center border rounded"
                />
                <p>{{ employeeForm.errors.firstname }}</p>
                <input
                    v-model="employeeForm.lastname"
                    type="text"
                    placeholder="გვარი"
                    class="p-2 text-center border rounded"
                />
                <p>{{ employeeForm.errors.lastname }}</p>
            </div>
            <p v-if="successMessage" class="text-center">
                {{ successMessage }}
            </p>
            <button class="p-2 mt-1 text-white bg-green-600 border rounded-lg">
                დამატება
            </button>
        </form>
    </div>
</template>
