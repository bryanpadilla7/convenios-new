import axios from "axios";

const instrumentDependenceApi = axios.create({
    baseURL: "/api/web/instrumentDependence",
});

export default instrumentDependenceApi;