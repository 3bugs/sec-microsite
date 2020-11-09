import Dashboard from './pages/dashboard';
import Fundraising from './pages/fundraising';
import FundraisingCategory from './pages/fundraising-category';
import Media from './pages/media';
import MediaMore from './pages/media-more';
import MediaCategory from './pages/media-category';

export const routeDataList = [
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    title: 'หน้าหลัก',
    menuIconName: 'mdi-home',
  },
  {
    title: 'เครื่องมือระดมทุน',
    menuIconName: 'mdi-bullhorn-outline',
    subItemList: [
      {
        path: '/fundraising',
        name: 'fundraising',
        component: Fundraising,
        title: 'เครื่องมือระดมทุน',
        menuTitle: 'เครื่องมือระดมทุน',
        menuIconName: 'mdi-content-copy',
      },
      {
        path: '/fundraising-category',
        name: 'fundraising-category',
        component: FundraisingCategory,
        title: 'หมวดหมู่เครื่องมือระดมทุน',
        menuTitle: 'หมวดหมู่เครื่องมือระดมทุน',
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
        title: 'สื่อการเรียนรู้ระดมทุน',
        menuTitle: 'สื่อการเรียนรู้ระดมทุน',
        menuIconName: 'mdi-content-copy',
      },
      {
        path: '/media-category',
        name: 'media-category',
        component: MediaCategory,
        title: 'หมวดหมู่สื่อการเรียนรู้ระดมทุน',
        menuTitle: 'หมวดหมู่สื่อการเรียนรู้ฯ',
        menuIconName: 'mdi-shape-outline',
      },
      {
        path: '/media-more',
        name: 'media-more',
        component: MediaMore,
        title: 'บทความ / Link ที่เกี่ยวข้อง',
        menuTitle: 'บทความ / Link ที่เกี่ยวข้อง',
        menuIconName: 'mdi-shape-outline',
      },
      /*{
        path: '/media-category',
        name: 'media-category',
        component: Media,
        title: 'Link อื่นๆ ที่เกี่ยวข้อง',
        menuTitle: 'Link อื่นๆ ที่เกี่ยวข้อง',
        menuIconName: 'mdi-shape-outline',
      },*/
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
  '#fbf7f0',
  '#ADE6D0',
  '#F1F0CF',
  '#EBCEED',
  '#DEB3EB',
  '#FEBCC8',
  '#FFFFD8',
  '#EAEBFF',
  '#E0FEFE',
  '#D3EEFF',
  '#F3EACE',
  '#E7F1D4',
  '#D7ECC9',
  '#C2DEDF',
];
