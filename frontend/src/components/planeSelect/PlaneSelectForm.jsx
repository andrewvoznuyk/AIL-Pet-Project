import {useContext, useEffect, useState} from "react";
import axios from "axios";
import {Breadcrumbs, FormControl, InputLabel, Link, MenuItem, Select, TextField, Typography} from "@mui/material";
import {responseStatus} from "../../utils/consts";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import PlaneForm from "./PlaneForm";

const PlaneSelectForm = () => {
    const [planes, setPlanes] = useState(null);
    const [currentPlane, setCurrentPlane] = useState(null);
    const [companyList, setCompanyList] = useState(null);
    const [currentCompany, setCurrentCompany] = useState(null);
    const [data,setData]=useState({
        serialNumber:null,
    })
    useEffect(() => {
        request();
        requestCompany();
    }, []);
    const request=()=>{
        axios.get("/api/aircraft-models?page=1&itemsPerPage=1000", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setPlanes(response.data["hydra:member"]);
            }
        }).catch(error => {
            console.log("error");
        });
    };
    const requestCompany=()=>{
        axios.get("/api/get-company-list", userAuthenticationConfig()).then(response => {
            console.log(response.data);
            if (response.status === responseStatus.HTTP_OK && response.data) {
                setCompanyList(response.data);
            }
        }).catch(error => {
            console.log("error");
        });
    };
    const SendData=(event)=>{
        event.preventDefault();

        //setData({...data, model: currentPlane.id, company: currentCompany.id});
        console.log(currentPlane.name);
        axios.post("", {data}, userAuthenticationConfig()).then(response => {
            alert("Data sended!");
            if (response.status === responseStatus.HTTP_CREATED) {
            }
        }).catch(error => {
            console.log("error");
        });
    };
    return (
        <>
            <form onSubmit={SendData}>
                <FormControl style={{width:600}}>
                    <InputLabel id="company-select-label">Company List</InputLabel>
                    <Select
                        labelId="company-select-label"
                        id="company-select"
                        label="Company List"
                    >
                        {companyList && companyList.map((item, key) => (
                            <MenuItem key={key} value={item.name} onClick={()=>{setCurrentCompany(item)}}>{item.name}</MenuItem>
                        ))}
                    </Select>

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
            </form>
        </>
    );
};

export default PlaneSelectForm;