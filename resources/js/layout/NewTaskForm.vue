<script setup>
import { defineProps, ref, toRefs, watch } from "vue";

const props = defineProps({
    showPopUpProp: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    taskTitle: {
        type: String,
        default: "",
    },
    taskDescription: {
        type: String,
        default: "",
    },
    taskCompleted: {
        type: Boolean,
        default: false,
    },
    onCheckTaskCompleted: {
        type: Function,
        required: true,
    },
    onSubmitTask: {
        type: Function,
        required: true,
    },
    submitAction: {
        type: String,
        required: true,
    },
});

// Create local state copies
// Create local state copies
const localTaskTitle = ref(props.taskTitle);
const localTaskDescription = ref(props.taskDescription);
const localTaskCompleted = ref(props.taskCompleted);
const localsubmitAction = ref(props.submitAction);

// Watch for changes and emit updates
const emit = defineEmits([
    "update:taskTitle",
    "update:taskDescription",
    "update:taskCompleted",
]);

watch(() => props.taskTitle, (newValue) => {
    localTaskTitle.value = newValue;
});

watch(() => props.taskDescription, (newValue) => {
    localTaskDescription.value = newValue;
});

watch(() => props.taskCompleted, (newValue) => {
    localTaskCompleted.value = newValue;
});

watch(localTaskTitle, (newValue) => {
    emit("update:taskTitle", newValue);
});

watch(localTaskDescription, (newValue) => {
    emit("update:taskDescription", newValue);
});

watch(localTaskCompleted, (newValue) => {
    emit("update:taskCompleted", newValue);
});

// Watch for changes in submitAction and reset the form state if it's for a new task
watch(localsubmitAction, (newValue) => {
    if (newValue === "Create Task") {
        localTaskTitle.value = "";
        localTaskDescription.value = "";
        localTaskCompleted.value = false;
    }
});
</script>

<template>
    <v-card :title="title">
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="localTaskTitle"
                            label="Task Title"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="v-row">
                    <v-col cols="12">
                        <v-textarea
                            label="Task Description"
                            v-model="localTaskDescription"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row class="v-row">
                    <v-col cols="12">
                        <v-checkbox
                            label="Task Completed"
                            @click="props.onCheckTaskCompleted"
                            v-model="localTaskCompleted"
                        />
                    </v-col>
                </v-row>
                <v-row class="v-row" justify="center">
                    <v-col cols="auto">
                        <v-btn
                            color="buttonSecondary"
                            @click="props.onSubmitTask"
                            >{{ props.submitAction }}</v-btn
                        >
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<style scoped>
.text-field {
    width: 400px;
}
</style>
