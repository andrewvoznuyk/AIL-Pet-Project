import { Button, Card, CardContent, Input, TextField, Typography } from "@mui/material";
import React, { useState } from "react";
import aircraftSettings from "./aircraftSettings";
import { Label } from "recharts";

function CardTicketInfo ({ placeData, changeOneTicketItem, ticketPricesArray }) {

  const getPriceByClass = () => {
    return ticketPricesArray[placeData.class];
  }

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
    placeData.bonus = e.target.value;
    changeOneTicketItem(placeData);
  };

  const onLuggageInput = (e) => {
    placeData.luggageMass = e.target.value;
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