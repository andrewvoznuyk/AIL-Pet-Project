import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Button, MenuItem, Select, FormControl, InputLabel} from "@mui/material";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import Notification from "../../elemets/notification/Notification";

const FlightsCreate = () => {

    const [company, setCompany] = useState('');
    const [fromAirport, setFromAirport] = useState(null);
    const [toAirport, setToAirport] = useState(null);

    const [loading, setLoading] = useState(false);
    const [notification, setNotification] = useState({
        visible: false,
        type: "",
        message: ""
    });

    const [airportList, setAirportList] = useState([]);
    const [companiesList, setCompaniesList] = useState([]);

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
            setNotification({...notification, visible: true, type: "success", message: "Company flight created!"});
        }).catch(error => {
            setNotification({...notification, visible: true, type: "error", message: error.response.data.title});
        }).finally(() => {
            setLoading(false);
        });
    }

    const fetchCompanies = () => {
        axios.get("/api/user-company", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data) {
                setCompaniesList(response.data);
            }
        }).catch(error => {
            setNotification({...notification, visible: true, type: "error", message: error.response.data.title});
        });
    };

    const fetchAirports = () => {
        axios.get("/api/airports", userAuthenticationConfig()).then(response => {
            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                setAirportList(response.data["hydra:member"]);
            }
        }).catch(error => {
            setNotification({...notification, visible: true, type: "error", message: error.response.data.title});
        });
    };

    useEffect(() => {
        fetchCompanies();
        fetchAirports();
    }, []);

    const availableToAirports = airportList.filter(item => item["@id"] !== fromAirport);

    return (
        <>
            {notification.visible &&
                <Notification notification={notification} setNotification={setNotification}/>
            }
            <form onSubmit={handleSubmit}>
                <div>
                    <FormControl style={{width: 500}}>
                        <InputLabel id="companyId">Company ID:</InputLabel>
                        <Select
                            labelId="companyId"
                            id="company"
                            label="company"
                            required
                        >
                            {companiesList && companiesList.map((item, key) => (
                                <MenuItem key={key} value={item.name} onClick={() => {
                                    setCompany(item.id)
                                }}>{item.name}</MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </div>
                <br/>
                <div>
                    <FormControl style={{width: 500}}>
                        <InputLabel id="fromInput">From</InputLabel>
                        <Select
                            labelId="fromInput"
                            id="from"
                            label="from"
                            required
                        >
                            {airportList && airportList.map((item, key) => (
                                <MenuItem key={key} value={item.name} onClick={() => {
                                    setFromAirport(item["@id"])
                                }}>{item.name} ({item.city}, {item.country})</MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </div>
                <br/>
                <div>
                    <FormControl style={{width: 500}}>
                        <InputLabel id="toInput">To</InputLabel>
                        <Select
                            labelId="toInput"
                            id="to"
                            label="to"
                            required
                        >
                            {availableToAirports && availableToAirports.map((item, key) => (
                                <MenuItem key={key} value={item.name} onClick={() => {
                                    setToAirport(item["@id"])
                                }}>{item.name} ({item.city}, {item.country})</MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                </div>
                <br/>
                <Button variant="contained" type="submit">
                    Create flight
                </Button>
            </form>
        </>
    );

};

export default FlightsCreate;