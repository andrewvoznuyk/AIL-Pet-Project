import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {TextField, Button, MenuItem, Select} from "@mui/material";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";

const FlightsCreate = () => {

    const [flights, setFlights] = useState({
        company: '',
        fromAirport: null,
        toAirport: null
    });

    const [loading, setLoading] = useState(false);

    const [airportList, setAirportList] = useState([]);
    const [comapniesList, setComapniesList] = useState([]);

    const handleChange = (event) => {
        const {name, value} = event.target;
        setFlights({...flights, [name]: value});
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        flushFlights();
    };

    const flushFlights = () => {
        setLoading(true);

        axios.post("api/company-flights", {
            company: flights.company,
            fromAirport: flights.fromAirport,
            toAirport: flights.toAirport
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

    return (
        <>
            <form onSubmit={handleSubmit}>
                <div>
                    Company ID:
                    <TextField
                        type="text"
                        name="company"
                        value={flights.company}
                        onChange={handleChange}
                    />
                </div>
                <div>
                    From:
                    <Select onChange={handleChange} label='From' name="fromAirport" value={flights.fromAirport}>
                        {airportList && airportList.map((item, key) => (
                            <MenuItem key={key}
                                    value={item["id"]}>{item["name"]} ({item["city"]}, {item["country"]})</MenuItem>
                        ))}
                    </Select>
                </div>
                <div>
                    To:
                    <Select onChange={handleChange} label='To' name="toAirport" value={flights.toAirport}>
                        {airportList && airportList.map((item, key) => (
                            <MenuItem key={key}
                                      value={item["id"]}>{item["name"]} ({item["city"]}, {item["country"]})</MenuItem>
                        ))}
                    </Select>
                </div>
                <Button variant="contained" type="submit">
                    Create flight
                </Button>
            </form>
        </>
    );

};

export default FlightsCreate;