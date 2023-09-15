import * as React from 'react';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import CircularProgress from '@mui/material/CircularProgress';
import {useEffect, useState} from "react";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import {responseStatus} from "../../../utils/consts";

function InputDataLoader({label}) {
    const [open, setOpen] = useState(false);
    const [options, setOptions] = useState([]);
    const [inputQuery, setInputQuery] = useState("");
    const loading = open && options.length === 0;

    const onInput = (e) => {
        setInputQuery(e.target.value);
    }
    const sendRequest = () => {
        axios.get(`/api/aircraft?serialNumber=${inputQuery}&itemsPerPage=1`, userAuthenticationConfig()).then(response => {

            if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
                let data = response.data["hydra:member"];
                setOptions(data);

                console.log(response.data["hydra:member"]);
                if(data.length === 0){
                    setOptions([]);
                }
            }
        })
    }

    useEffect(() => {
        let active = true;

        sendRequest();

        return () => {
            active = false;
        };
    }, [loading, inputQuery]);

    useEffect(() => {
        if (!open) {
            setOptions([]);
        }
    }, [open]);

    return (
        <Autocomplete
            onInput={onInput}
            sx={{width: 300}}
            open={open}
            onOpen={() => {
                setOpen(true);
            }}
            onClose={() => {
                setOpen(false);
            }}
            isOptionEqualToValue={(option, value) => option.title === value.title}
            getOptionLabel={(option) => option.serialNumber}
            options={options}
            loading={loading}
            renderInput={(params) => (
                <TextField
                    {...params}
                    label={label}
                    /*InputProps={{
                        ...params.InputProps,
                        endAdornment: (
                            <React.Fragment>
                                {loading ? <CircularProgress color="inherit" size={20}/> : null}
                                {params.InputProps.endAdornment}
                            </React.Fragment>
                        ),
                    }}*/
                />
            )}
        />
    );
}

const topFilms = [
    {title: 'The Shawshank Redemption', year: 1994},
    {title: 'The Godfather', year: 1972}
];

export default InputDataLoader;