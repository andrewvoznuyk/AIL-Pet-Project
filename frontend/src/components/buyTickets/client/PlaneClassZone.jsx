import Grid from "@mui/material/Grid";
import SeatItem from "./SeatItem";
import SeatsRow from "./SeatsRow";

/**
 * Each plane has several classes divided
 */
function PlaneClassZone ({ classZone, onButtonClick }) {

  return <>
    {
      classZone && classZone.seats.map((row, key) => {
        return (

          <tr className="centered-table">
            <SeatsRow row={row} onButtonClick={onButtonClick} placeClass={classZone.className}/>
          </tr>

        );
      })
    }
  </>;
}

export default PlaneClassZone;