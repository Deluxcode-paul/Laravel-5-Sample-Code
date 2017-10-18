// lazy load example for components - TODO
// const Component = resolve => require(['./Component.vue'], resolve);

// Filters Components
import FiltersRecipe from '../components/listing/filters/FiltersRecipe.vue'
import FiltersLifestyle from '../components/listing/filters/FiltersLifestyle.vue'
import FiltersChef from '../components/listing/filters/FiltersChef.vue'
import FiltersWatch from '../components/listing/filters/FiltersWatch.vue'

// Item Components
import ItemRecipe from '../components/listing/items/ItemRecipe.vue'
import ItemArticle from '../components/listing/items/ItemArticle.vue'
import ItemChef from '../components/listing/items/ItemChef.vue'
import ItemWatch from '../components/listing/items/ItemWatch.vue'
import ItemShow from '../components/listing/items/ItemShow.vue'

const Subcategory = require('../components/listing/Subcategory.vue');
const Search = require('../components/listing/Search.vue');
const GenerateMeal = require('../components/listing/GenerateMeal.vue');
const Lifestyle = require('../components/listing/Lifestyle.vue');
const Listing = require('../components/listing/Listing.vue');
const MyArticles = require('../components/listing/MyArticles.vue');
const MyRecipes = require('../components/listing/MyRecipes.vue');
const Activity = require('../components/listing/Activity.vue');
const RecipeBox = require('../components/listing/RecipeBox.vue');
const Community = require('../components/listing/Community.vue');
const CommunityReplies = require('../components/listing/CommunityReplies.vue');

const WatchLanding = $.extend(true, {}, Listing);
WatchLanding.components.item = ItemWatch;

const ShowLanding = $.extend(true, {}, Listing);
ShowLanding.components.item = ItemShow;

export default {
    mode: 'history',
    routes: [
        {
            name: 'Subcategory',
            path: '/recipes/list',
            component: Subcategory
        },
        {
            name: 'Search',
            path: '/search/:section',
            component: Search,
            beforeEnter(to, from, next) {
                var matched = to.matched[0].components.default;

                switch (to.params.section) {
                    case 'lifestyle':
                        matched.components.item = ItemArticle;
                        matched.components.filters = FiltersLifestyle;
                        break;
                    case 'recipes':
                        matched.components.item = ItemRecipe;
                        matched.components.filters = FiltersRecipe;
                        break;
                    case 'chef':
                        matched.components.item = ItemChef;
                        matched.components.filters = FiltersChef;
                        break;
                    case 'watch':
                        matched.components.item = ItemWatch;
                        matched.components.filters = FiltersWatch;
                        break;
                }
                next();
            }
        },
        {
            name: 'Lifestyle',
            path: '/lifestyle',
            component: Lifestyle
        },
        {
            name: 'Watch Landing',
            path: '/watch',
            component: WatchLanding
        },
        {
            name: 'Show Landing',
            path: '/watch/show/:id',
            component: ShowLanding
        },
        {
            name: 'Generate a meal',
            path: '/generate-a-meal',
            component: GenerateMeal
        },
        {
            name: 'My Articles',
            path: '/user/profile/my-articles',
            component: MyArticles
        },
        {
            name: 'My Recipes',
            path: '/user/profile/my-recipes',
            component: MyRecipes
        },
        {
            name: 'Activity',
            path: '/user/profile/activity/:section',
            component: Activity
        },
        {
            name: 'Recipe Box',
            path: '/user/profile/recipe-box',
            component: RecipeBox
        },
        {
            name: 'Community Landing Page',
            path: '/community',
            component: Community
        },
        {
            name: 'Community Detail',
            path: '/community/recipe-review/:id',
            component: CommunityReplies
        }
    ]
}