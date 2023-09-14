import {useContext, useEffect, useState} from "react";
import axios from "axios";
import {Breadcrumbs, FormControl, InputLabel, Link, MenuItem, Select, TextField, Typography} from "@mui/material";
import {responseStatus} from "../../utils/consts";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import PlaneForm from "./PlaneForm";

const PlaneSelectForm = () => {
    const [planes, setPlanes] = useState(null);
    const [currentPlane, setCurrentPlane] = useState(null);
    useEffect(() => {
        request();
    }, []);
    const request=()=>{
        axios.get("/api/aircraft-models?page=1&itemsPerPage=1000", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setPlanes(response.data["hydra:member"]);
                console.log(response.data["hydra:member"]);
            }
        }).catch(error => {
            console.log("error");
        });
    };
    console.log(currentPlane);
    return (
        <>
            <FormControl style={{width:600}}>
                <InputLabel id="demo-simple-select-label">AirPlanes</InputLabel>
                <Select
                    labelId="demo-simple-select-label"
                    id="demo-simple-select"
                    label="Aiplanes"
                >
                    {planes && planes.map((item, key) => (
                        <MenuItem key={key} value={item.plane} onClick={()=>{setCurrentPlane(item)}}>{item.plane}</MenuItem>
                    ))}
                </Select>
                {currentPlane && <PlaneForm currentPlane={currentPlane}/>}
            </FormControl>
        </>
    );
};

export default PlaneSelectForm;