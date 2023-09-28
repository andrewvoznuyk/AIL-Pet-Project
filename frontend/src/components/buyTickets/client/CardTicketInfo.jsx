import { Card, CardContent, TextField, Typography } from "@mui/material";
import React from "react";

function CardTicketInfo ({ placeData, changeOneTicketItem, ticketPricesArray }) {

  const getPriceByClass = () => {
    return ticketPricesArray[placeData.class];
  };

  const onNameInput = (e) => {
    placeData.name = e.target.value;
    changeOneTicketItem(placeData);
  };

  const onSurnameInput = (e) => {
    placeData.surname = e.target.value;
    changeOneTicketItem(placeData);
  };

  const onDocumentIdInput = (e) => {
    placeData.documentId = e.target.value;
    changeOneTicketItem(placeData);
  };

  const onBonusesInput = (e) => {
    if (e.target.value < 0) {
      e.target.value = 0;
    }

    placeData.bonus = parseInt(e.target.value);
    changeOneTicketItem(placeData);
  };

  const onLuggageInput = (e) => {
    if (e.target.value < 0) {
      e.target.value = 0;
    }

    placeData.luggageMass = parseInt(e.target.value);
    changeOneTicketItem(placeData);
  };

  const onBirthInput = (e) => {
    placeData.birthDate = e.target.value;
    changeOneTicketItem(placeData);
  };

  return <>
    <Card>
      <CardContent>
        <Typography color="textSecondary" gutterBottom>
          Place #{placeData.place} ({placeData.class})
        </Typography>

        <form>
          <TextField
            variant="standard"
            type="text"
            label="Name"
            name="name"
            required={true}
            onInput={onNameInput}
          />
          <p></p>
          <TextField
            variant="standard"
            type="text"
            label="Surname"
            name="surname"
            required={true}
            onInput={onSurnameInput}
          />
          <p></p>
          <TextField
            variant="standard"
            type="text"
            label="Document ID"
            name="documentId"
            required={true}
            onInput={onDocumentIdInput}
          />
          <p></p>
          <TextField
            variant="standard"
            type="date"
            name="birthDate"
            placeholder=""
            required={true}
            onInput={onBirthInput}
          />
          <p></p>

          <TextField
            variant="standard"
            type="number"
            label="Luggage, kg"
            name="luggageMass"
            defaultValue={0}
            required={true}
            onInput={onLuggageInput}
          />
          <p></p>
          <TextField
            variant="standard"
            type="number"
            label="Bonuses"
            name="bonus"
            defaultValue={0}
            required={true}
            onInput={onBonusesInput}
          />
          <p></p>

          <Typography color="textPrimary" gutterBottom>
            {placeData.price}$
          </Typography>
        </form>
      </CardContent>
    </Card>

  </>;
}

export default CardTicketInfo;