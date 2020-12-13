import Dashboard from './pages/dashboard';
import Fundraising from './pages/fundraising';
import FundraisingCategory from './pages/fundraising-category';
import Media from './pages/media';
import MediaMore from './pages/media-more';
import MediaCategory from './pages/media-category';
import Event from './pages/event';
import EventCategory from './pages/event-category';
import Contact from './pages/contact';
import Vision from './pages/vision';
import SurveyResults from './pages/survey-results';
import Banner from './pages/banner';

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
        title: 'ข้อมูลที่ต้องรู้ / บทความที่เกี่ยวข้อง',
        menuTitle: 'ข้อมูลที่ต้องรู้ / บทความที่เกี่ยวข้อง',
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
  {
    title: 'SEC Event',
    menuIconName: 'mdi-calendar-clock',
    subItemList: [
      {
        path: '/event',
        name: 'event',
        component: Event,
        title: 'SEC Event',
        menuTitle: 'SEC Event',
        menuIconName: 'mdi-content-copy',
      },
      {
        path: '/event-category',
        name: 'event-category',
        component: EventCategory,
        title: 'หมวดหมู่ SEC Event',
        menuTitle: 'หมวดหมู่ SEC Event',
        menuIconName: 'mdi-shape-outline',
      },
    ],
  },
  {
    path: '/contact',
    name: 'contact',
    component: Contact,
    title: 'ข้อมูลผู้ติดต่อ',
    menuTitle: 'คลินิกระดมทุน',
    menuIconName: 'mdi-card-account-phone'
  },
  {
    path: '/vision',
    name: 'vision',
    component: Vision,
    title: 'ก.ล.ต. กับ SMEs',
    menuTitle: 'ก.ล.ต. กับ SMEs',
    menuIconName: 'mdi-lightbulb-on-outline'
  },
  {
    path: '/survey-results',
    name: 'survey-results',
    component: SurveyResults,
    title: 'Survey Results',
    menuTitle: 'Survey Results',
    menuIconName: 'mdi-chart-bar'
  },
  {
    path: '/banner',
    name: 'banner',
    component: Banner,
    title: 'แบนเนอร์',
    menuTitle: 'แบนเนอร์',
    menuIconName: 'mdi-card-text-outline'
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
  '#D3EEFF',
  '#FEBCC8',
  '#ADE6D0',
  '#DEB3EB',
  '#f4dada',
  '#f6eec7',
  '#d9e4dd',
  //'#fbf7f0',
  '#F1F0CF',
  '#E0FEFE',
  '#EBCEED',
  '#FFFFD8',
  '#EAEBFF',
  '#beebe9',
  '#F3EACE',
  '#E7F1D4',
  '#D7ECC9',
  '#C2DEDF',
];
