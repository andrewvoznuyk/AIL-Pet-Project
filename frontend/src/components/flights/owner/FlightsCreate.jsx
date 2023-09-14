import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {TextField, Button, MenuItem, Select, FormControl, InputLabel} from "@mui/material";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";

const FlightsCreate = () => {

    const [company, setCompany] = useState('');
    const [fromAirport, setFromAirport] = useState(null);
    const [toAirport, setToAirport] = useState(null);

    const [loading, setLoading] = useState(false);

    const [airportList, setAirportList] = useState([]);
    const [comapniesList, setComapniesList] = useState([]);

    const handleSubmit = (event) => {
        event.preventDefault();
        flushFlights();
    };

    const flushFlights = () => {
        setLoading(true);

        axios.post("api/company-flights", {
            company: company,
            fromAirport: fromAirport,
            toAirport: toAirport
        }, userAuthenticationConfig(false)).then(response => {
            console.log("add!")
        }).catch(error => {
            console.log("error!")
        }).finally(() => {
            setLoading(false)
        });
    }

    const fetchAirports = () => {
        axios.get("/api/airports", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setAirportList(response.data["hydra:member"]);
            }
        }).catch(error => {
            console.log("error List");
        });
    };

    const fetchCompanies = () => {
        axios.get("/api/companies", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setComapniesList(response.data["hydra:member"]);
            }
        }).catch(error => {
            console.log("error List");
        });
    };

    useEffect(() => {
        fetchAirports();
        fetchCompanies();
    }, []);

    const availableToAirports = airportList.filter(item => item["@id"] !== fromAirport);

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div>
                    Company ID:
                    <TextField
                        type="text"
                        name="company"
                        value={company}
                        onChange={(e)=>{setCompany(e.target.value)}}
                    />
                </div>
                <div>
                    <FormControl style={{width:500}}>
                        <InputLabel id="fromInput">From</InputLabel>
                        <Select
                            labelId="fromInput"
                            id="from"
                            label="from"
                        >
                            {airportList && airportList.map((item, key) => (
                                <MenuItem key={key} value={item.name} onClick={()=>{setFromAirport(item["@id"])}}>{item.name} ({item.city}, {item.country})</MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </div>
                <br/>
                <div>
                    <FormControl style={{width:500}}>
                        <InputLabel id="toInput">To</InputLabel>
                        <Select
                            labelId="toInput"
                            id="to"
                            label="to"
                        >
                            {availableToAirports && availableToAirports.map((item, key) => (
                                <MenuItem key={key} value={item.name} onClick={()=>{setToAirport(item["@id"])}}>{item.name} ({item.city}, {item.country})</MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </div>
                <Button variant="contained" type="submit">
                    Create flight
                </Button>
            </form>
        </>
    );

};

export default FlightsCreate;