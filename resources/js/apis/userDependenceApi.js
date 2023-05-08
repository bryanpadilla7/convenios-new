import axios from "axios";

const userDependenceApi = axios.create({
    baseURL: "/api/web/userDependence",
});

export default userDependenceApi;