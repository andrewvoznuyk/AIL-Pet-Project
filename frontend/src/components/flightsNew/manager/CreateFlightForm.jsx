import React, { useState } from "react";
import {
  Box,
  Button, Card, CardContent,
  FormControl, Grid,
  TextField,
  Typography
} from "@mui/material";
import InputDataLoader from "../../elemets/input/InputDataLoader";

const CreateFlightForm = ({ setData, loading }) => {

  const [plane, setPlane] = useState(null);
  const [airportFrom, setAirportFrom] = useState(null);
  const [airportTo, setAirportTo] = useState(null);

  const handleSubmit = (event) => {
    event.preventDefault();

    if (!plane || !airportFrom || !airportTo) {
      return;
    }

    const data = {
      aircraft: plane.id,
      fromLocation: airportFrom.id,
      toLocation: airportTo.id,
      initPrices: {
        "business": event.target.businessPrice.value,
        "econom": event.target.economPrice.value,
        "standard": event.target.standardPrice.value
      },
      priceCoef: {
        "business": event.target.businessCoef.value,
        "econom": event.target.economCoef.value,
        "standard": event.target.standardCoef.value
      }
    };

    setData(data);
    //console.log(data);
  };

  return (
    <Box
      sx={{
        marginTop: 8,
        display: "flex",
        flexDirection: "column",
        alignItems: "center"
      }}
    >
      <Grid container>
        <Grid item xs={11} lg={6}>
          <form onSubmit={handleSubmit}>
            <Typography variant="h4" component="h1">
              Create flight
            </Typography>

            <FormControl style={{ width: 500 }}>

              <div>
                <Typography variant="h6">
                  Start prices
                </Typography>

                <TextField
                  variant="outlined"
                  type="text"
                  label="Business class"
                  name="businessPrice"
                  required
                />

                <p></p>

                <TextField
                  type="text"
                  variant="outlined"
                  label="Economy class"
                  name="economPrice"
                  required
                />

                <p></p>

                <TextField
                  type="text"
                  variant="outlined"
                  label="Standard class"
                  name="standardPrice"
                  required
                />

                <p></p>
              </div>


              <div>
                <Typography variant="h6">
                  Price coefficients
                </Typography>
                <TextField
                  variant="outlined"
                  type="text"
                  label="Business class"
                  name="businessCoef"
                  value={1}
                  required
                />

                <p></p>

                <TextField
                  type="text"
                  variant="outlined"
                  label="Economy class"
                  name="economCoef"
                  value={1}
                  required
                />

                <p></p>

                <TextField
                  type="text"
                  variant="outlined"
                  label="Standard class"
                  name="standardCoef"
                  value={1}
                  required
                />

                <p></p>
              </div>


              <InputDataLoader
                name="aircraft"
                label="Select Aircraft"
                url="/api/aircraft"
                searchWord="serialNumber"
                getOptionLabel={(option) => option.serialNumber}
                onChange={(e, v) => setPlane(v)}
              />

              <p></p>

              <InputDataLoader
                name="fromLocation"
                label="From"
                url="/api/company-flights"
                searchWord="name"
                getOptionLabel={(option) => `${option.airport.name} (${option.airport.city})`}
                onChange={(e, v) => setAirportFrom(v)}
              />

              <p></p>

              <InputDataLoader
                name="toLocation"
                label="To"
                url="/api/company-flights"
                searchWord="name"
                getOptionLabel={(option) => option.airport.name}
                onChange={(e, v) => setAirportTo(v)}
              />

              <p></p>

              <TextField
                name="departure"
                type="datetime-local"
                InputLabelProps={{
                  shrink: true
                }}
                label="Departure"
                required={true}
              />

              <p></p>

              <Button
                variant="contained"
                type="submit"
                disabled={loading}
              >
                Create
              </Button>
            </FormControl>
          </form>
        </Grid>
      </Grid>
    </Box>
  );
};

export default CreateFlightForm;