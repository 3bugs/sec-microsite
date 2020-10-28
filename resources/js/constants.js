import Dashboard from "./pages/dashboard";
import Fundraising from "./pages/fundraising";
import FundraisingCategory from "./pages/fundraising-category";

export const routeDataList = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    title: 'หน้าหลัก',
    menuIconName: 'mdi-home',
  },
  {
    path: '/fundraising',
    name: 'fundraising',
    component: Fundraising,
    title: 'วิธีการระดมทุน',
    menuIconName: 'mdi-bitcoin',
  },
  {
    path: '/fundraising-category',
    name: 'fundraising-category',
    component: FundraisingCategory,
    title: 'หมวดหมู่วิธีการระดมทุน',
    menuIconName: 'mdi-bitcoin',
  },
];

export const fundraisingCategoryColorList = [
  '#beebe9',
  '#f4dada',
  '#f6eec7',
  '#d9e4dd',
  '#fbf7f0'
];
