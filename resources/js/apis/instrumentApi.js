import axios from "axios";

const instrumentApi = axios.create({
    baseURL: "/api/web/instrument",
});

export default instrumentApi;
