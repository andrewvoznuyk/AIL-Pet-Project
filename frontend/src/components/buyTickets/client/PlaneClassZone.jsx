import SeatsRow from "./SeatsRow";

/**
 * Each plane has several classes divided
 */
function PlaneClassZone ({ classZone, onButtonClick, isPlaceSold }) {

  return <>
    {
      classZone && classZone.seats.map((row, key) => {
        return (

          <tr className="centered-table">
            <SeatsRow
              row={row}
              onButtonClick={onButtonClick}
              placeClass={classZone.className}
              isPlaceSold={isPlaceSold}
            />
          </tr>

        );
      })
    }
  </>;
}

export default PlaneClassZone;