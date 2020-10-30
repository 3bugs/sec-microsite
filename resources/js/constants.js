import Dashboard from './pages/dashboard';
import Fundraising from './pages/fundraising';
import FundraisingCategory from './pages/fundraising-category';
import Media from './pages/media';

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
  {
    path: '/media',
    name: 'media',
    component: Media,
    title: 'สื่อการเรียนรู้ระดมทุน',
    menuIconName: 'mdi-laptop',
  },
];

export const categoryColorList = [
  '#beebe9',
  '#f4dada',
  '#f6eec7',
  '#d9e4dd',
  '#fbf7f0'
];
