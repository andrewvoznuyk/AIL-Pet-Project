import React, { useState } from "react";
import {
  Box,
  Button, Card, CardContent,
  FormControl, Grid,
  IconButton,
  Input,
  InputAdornment,
  InputLabel, Link,
  TextField,
  Typography
} from "@mui/material";
import { Visibility, VisibilityOff } from "@mui/icons-material";
import InputCustom from "../elemets/input/InputCustom";
import InputPassword from "../elemets/input/InputPassword";
import InputPhoneNumber from "../elemets/input/InputPhoneNumber";
import InputDataLoader from "../elemets/input/InputDataLoader";
import InputAddRemove from "../elemets/input/InputAddRemove";

const CreateFlightForm = ({ setData, loading }) => {

  const [plane, setPlane] = useState(null);

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = {
      aircraft: plane.id,
      initPrices: {
        "business": event.target.businessPrice.value,
        "econom": event.target.economPrice.value,
        "standard": event.target.standardPrice.value,
      }
    };

    //setData(data);
    console.log(data);
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
        <Grid item xs={11} lg={5}>
          <form onSubmit={handleSubmit}>
            <Typography variant="h4" component="h1">
              Create flight
            </Typography>

            <InputCustom
              type="text"
              label="Start price (business)"
              name="businessPrice"
              required
            />

            <p></p>

            <InputCustom
              type="text"
              label="Start price (econom)"
              name="economPrice"
              required
            />

            <p></p>

            <InputCustom
              type="text"
              label="Start price (standard)"
              name="standardPrice"
              required
            />

            <p></p>

            <InputDataLoader
              name="test"
              label="Select Aircraft"
              url="/api/aircraft"
              searchWord="serialNumber"
              getOptionLabel={(option) => option.serialNumber}
              onChange={(e, v) => setPlane(v)}
            />

            <Button
              variant="contained"
              type="submit"
              disabled={loading}
            >
              Create
            </Button>
          </form>
        </Grid>
      </Grid>
    </Box>
  );
};

export default CreateFlightForm;