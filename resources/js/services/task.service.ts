import axios from "axios";

const endpoints = {
    getTasks: "/tasks/",
    storeTask: "/tasks/store",
    deleteTask: "/tasks/",
    editTask: "/tasks/",
};

const headers = {
    "Content-Type": "application/json",
    "Access-Control-Allow-Origin": "*",
};

const getCsrfToken = () => {
    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    return tokenElement ? tokenElement.getAttribute("content") : "";
};

const baseUrl = "http://localhost:8000/api";
axios.defaults.headers.common["X-CSRF-TOKEN"] = getCsrfToken();

export const getTaskService = async () => {
    const axiosConfig = {
        method: "GET",
        url: baseUrl + endpoints.getTasks,
        headers: headers,
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};

export const createTaskService = async (data) => {
    const { task_title, task_description, task_completed } = data;

    const axiosConfig = {
        method: "POST",
        url: baseUrl + endpoints.storeTask,
        data: {
            task_title: task_title,
            task_description: task_description,
            task_completed: task_completed,
        },
        headers: headers,
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};

export const deleteTaskService = async (id: number) => {
    const axiosConfig = {
        method: "DELETE",
        url: `${baseUrl}${endpoints.deleteTask}${id}`,
        headers: {
            ...headers,
            "X-CSRF-TOKEN": getCsrfToken(),
        },
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};

export const editTaskService = async (data: any) => {
    const { id, task_title, task_description, task_completed } = data;
    const axiosConfig = {
        method: "PUT",
        url: `${baseUrl}${endpoints.editTask}${id}`,
        data: {
            task_title: task_title,
            task_description: task_description,
            task_completed: task_completed,
        },
        headers: {
            ...headers,
            "X-CSRF-TOKEN": getCsrfToken(),
        },
    };

    return await axios
        .request(axiosConfig)
        .then((res) => {
            return {
                isError: false,
                data: res.data,
                error: "",
            };
        })
        .catch((err) => {
            return {
                isError: true,
                data: "",
                error: err,
            };
        });
};
