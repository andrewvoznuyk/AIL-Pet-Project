import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { AppContext } from "../../App";
import { buyTickets } from "../../rbac-consts";
import BuyTicketsContainer from "../../components/buyTickets/client/BuyTicketsContainer";

const GoodsPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
      <Can
        role={user.roles}
        perform={buyTickets.USER}
        yes={() => <BuyTicketsContainer />}
      />
    </>
  );
};

export default GoodsPage;