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
    title: 'วิธีการระดมทุน',
    menuIconName: 'mdi-bitcoin',
    subItemList: [
      {
        path: '/fundraising',
        name: 'fundraising',
        component: Fundraising,
        title: 'วิธีการระดมทุน',
        menuTitle: 'วิธีการระดมทุน',
        menuIconName: 'mdi-content-copy',
      },
      {
        path: '/fundraising-category',
        name: 'fundraising-category',
        component: FundraisingCategory,
        title: 'หมวดหมู่วิธีการระดมทุน',
        menuTitle: 'หมวดหมู่วิธีการระดมทุน',
        menuIconName: 'mdi-shape-outline',
      },
    ],
  },
  {
    title: 'แหล่งข้อมูลระดมทุน',
    menuIconName: 'mdi-laptop',
    subItemList: [
      {
        path: '/media',
        name: 'media',
        component: Media,
        title: 'แหล่งข้อมูลระดมทุน > สื่อการเรียนรู้ระดมทุน',
        menuTitle: 'สื่อการเรียนรู้ระดมทุน',
        menuIconName: 'mdi-content-copy',
      },
      {
        path: '/media-category',
        name: 'media-category',
        component: Media,
        title: 'หมวดหมู่สื่อการเรียนรู้ระดมทุน',
        menuTitle: 'หมวดหมู่สื่อการเรียนรู้ฯ',
        menuIconName: 'mdi-shape-outline',
      },
      {
        path: '/media-category',
        name: 'media-category',
        component: Media,
        title: 'แหล่งข้อมูลระดมทุน > บทความที่เกี่ยวข้อง',
        menuTitle: 'บทความที่เกี่ยวข้อง',
        menuIconName: 'mdi-shape-outline',
      },
      {
        path: '/media-category',
        name: 'media-category',
        component: Media,
        title: 'แหล่งข้อมูลระดมทุน > Link อื่นๆ ที่เกี่ยวข้อง',
        menuTitle: 'Link อื่นๆ ที่เกี่ยวข้อง',
        menuIconName: 'mdi-shape-outline',
      },
    ],
  },
];

export const getRouteTitle = (routeName) => {
  const resultList = [];
  routeDataList.forEach(item => {
    if (item.subItemList == null) {
      resultList.push(item);
    } else {
      item.subItemList.forEach(subItem => {
        resultList.push(subItem);
      });
    }
  });
  return resultList.filter(
    item => item.name === routeName
  )[0].title;
};

export const categoryColorList = [
  '#beebe9',
  '#f4dada',
  '#f6eec7',
  '#d9e4dd',
  '#fbf7f0'
];
