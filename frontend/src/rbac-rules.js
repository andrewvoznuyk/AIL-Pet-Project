import { goods, flights, toolbar, buyTickets, aircrafts } from "./rbac-consts";

const rules = {
  ROLE_ADMIN: {
    static: [
      goods.ADMIN,
      toolbar.ADMIN,
      flights.ADMIN
    ],
    dynamic: {}
  },

  ROLE_USER: {
    static: [
      goods.USER,
      flights.USER,
      toolbar.USER,
      buyTickets.USER
    ],
    dynamic: {}
  },

  ROLE_OWNER: {
    static: [
      flights.OWNER,
      toolbar.OWNER,
      goods.OWNER,
      aircrafts.OWNER
    ],
    dynamic: {}
  },

  ROLE_MANAGER: {
    static: [
      flights.MANAGER,
      toolbar.MANAGER,
      goods.MANAGER
    ],
    dynamic: {}
  }
};

export default rules;