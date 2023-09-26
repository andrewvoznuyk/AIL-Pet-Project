import {useContext, useEffect, useState} from "react";
import axios from "axios";
import {Breadcrumbs, FormControl, InputLabel, Link, MenuItem, Select, TextField, Typography} from "@mui/material";
import {responseStatus} from "../../utils/consts";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import PlaneForm from "./PlaneForm";

const PlaneSelectForm = () => {
    const [planes, setPlanes] = useState(null);
    const [currentPlane, setCurrentPlane] = useState({
        id:""
    });
    const [companyList, setCompanyList] = useState(null);
    const [currentCompany, setCurrentCompany] = useState({
        id:""
    });
    const [data,setData]=useState({
        model:"",
        serialNumber:"",
        company:"",
        columns:[2,2]
    })

    useEffect(()=>{
        request();
        requestCompany();
    },[]);
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
        axios.get("/api/user-company", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data) {
                setCompanyList(response.data);
            }
        }).catch(error => {
            console.log("error");
        });
    };

    const SendData=(event)=>{
        event.preventDefault();
        console.log(currentPlane);
        setData({...data, model: "/api/aircraft-models/"+currentPlane.id, company: "/api/companies/"+currentCompany.id});
        console.log(data);
        axios.post("/api/aircraft",data,userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_CREATED) {
                alert("Aircraft is added!");
            }
        }).catch(error => {
            alert("There are same number in Database!");
            console.log(error.response)
        });
    };

    return (
        <>
            <form onSubmit={SendData} style={{marginTop:20}}>
                <FormControl style={{width:600}}>
                    <InputLabel id="company-select-label">Company List</InputLabel>
                    <Select
                        labelId="company-select-label"
                        id="company-select"
                        label="Company List"
                    >
                        {companyList && companyList.map((item, key) => (
                            <MenuItem key={key} value={item.name} onClick={()=>{setCurrentCompany(item);setData({...data, company: "/api/companies/"+item.id});}}>{item.name}</MenuItem>
                        ))}
                    </Select>
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        label="Aiplanes"
                    >
                        {planes && planes.map((item, key) => (
                            <MenuItem key={key} value={item.plane} onClick={()=>{setCurrentPlane(item);setData({...data, model: "/api/aircraft-models/"+item.id});}}>{item.plane}</MenuItem>
                        ))}
                    </Select>
                    {currentPlane.plane && <PlaneForm currentPlane={currentPlane}  data={data} setData={setData}/>}
                </FormControl>
            </form>
        </>
    );
};

export default PlaneSelectForm;