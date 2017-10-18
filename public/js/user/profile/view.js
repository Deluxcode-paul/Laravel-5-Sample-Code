var Profile = {
    selectors : {
        recipesContainer: '.js-recipes-container',
        videosContainer: '.js-videos-container',
        articlesContainer: '.js-articles-container',
        commentsContainer: '.js-comments-container',

        recipeQuestionsButton: '.js-recipe-questions-button',
        recipeReviewsButton: '.js-recipe-reviews-button',
        articleCommentsButton: '.js-article-comments-button',
        communityQuestionsButton: '.js-community-questions-button',

        articleCommentsContainer: '.js-article-comments-container',
        communityQuestionsContainer: '.js-community-questions-container',
        recipeQuestionsContainer: '.js-recipe-questions-container',
        recipeReviewsContainer: '.js-recipe-reviews-container',

        loadRecipeQuestionsButton: '.js-load-recipe-questions-button',
        loadRecipeReviewsButton: '.js-load-recipe-reviews-button',
        loadCommunityQuestionsButton: '.js-load-community-questions-button',
        loadArticleCommentsButton: '.js-load-article-comments-button',

        recipeQuestionsList: '.js-recipe-questions-list',
        recipeReviewsList: '.js-recipe-reviews-list',
        communityQuestionsList: '.js-community-questions-list',
        articleCommentsList: '.js-article-comments-list',

        loadRecipesButton: '.js-load-recipes-button',
        loadArticlesButton: '.js-load-articles-button',
        loadVideosButton: '.js-load-videos-button',

        recipesList: '.js-recipes-list',
        articlesList: '.js-articles-list',
        videosList: '.js-videos-list',

        emailButton: '.js-email-profile-button'
    },
    constants: {
        hiddenClass: 'js-hidden',
        activeContainerClass: 'r-tabs-state-active',
        activeCommentsContainerClass: 'active'
    },
    currentContainer : '.js-recipes-container',
    currentButton: '.js-recipes-button',
    currentCommentsButton: '.js-recipe-questions-button',
    currentCommentsContainer : '.js-recipe-questions-container',

    recipesPage: 1,
    articlesPage: 1,
    videosPage: 1,

    recipeQuestionsPage: 1,
    recipeReviewsPage: 1,
    communityQuestionsPage: 1,
    articleCommentsPage: 1,

    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        // Main tabs
        $(self.selectors.loadRecipesButton).on('click', function(event) {
            event.preventDefault();
            self.loadRecipes();
        });
        $(self.selectors.loadArticlesButton).on('click', function(event) {
            event.preventDefault();
            self.loadArticles();
        });
        $(self.selectors.loadVideosButton).on('click', function(event) {
            event.preventDefault();
            self.loadVideos();
        });
        // Comment tabs
        $(self.selectors.recipeQuestionsButton).on('click', function(event) {
            event.preventDefault();
            self.switchCommentsContainer(self.selectors.recipeQuestionsContainer, this);
        });
        $(self.selectors.recipeReviewsButton).on('click', function(event) {
            event.preventDefault();
            self.switchCommentsContainer(self.selectors.recipeReviewsContainer, this);
        });
        $(self.selectors.articleCommentsButton).on('click', function(event) {
            event.preventDefault();
            self.switchCommentsContainer(self.selectors.articleCommentsContainer, this);
        });
        $(self.selectors.communityQuestionsButton).on('click', function(event) {
            event.preventDefault();
            self.switchCommentsContainer(self.selectors.communityQuestionsContainer, this);
        });
        $(self.selectors.loadRecipeQuestionsButton).on('click', function(event) {
            event.preventDefault();
            self.loadRecipeQuestions();
        });
        $(self.selectors.loadRecipeReviewsButton).on('click', function(event) {
            event.preventDefault();
            self.loadRecipeReviews();
        });
        $(self.selectors.loadCommunityQuestionsButton).on('click', function(event) {
            event.preventDefault();
            self.loadCommunityQuestions();
        });
        $(self.selectors.loadArticleCommentsButton).on('click', function(event) {
            event.preventDefault();
            self.loadArticleComments();
        });
        // Email
        $(self.selectors.emailButton).on('click', function(event) {
            event.preventDefault();
            EmailShare.showEmailPopup();
        });
        // Current tab highlight
        $(self.currentButton).parent().addClass(self.constants.activeContainerClass);
        $(self.currentCommentsButton).parent().addClass(self.constants.activeCommentsContainerClass);
    },
    switchContainer: function(container, handler) {
        var self = this;
        self.hide(self.currentContainer, self.currentButton);
        self.show(container, handler);
        $(handler).parent().addClass(self.constants.activeContainerClass);
    },
    switchCommentsContainer: function(container, handler) {
        var self = this;
        self.hideComments(self.currentCommentsContainer, self.currentCommentsButton);
        self.showComments(container, handler);
        $(handler).parent().addClass(self.constants.activeCommentsContainerClass);
    },
    show: function(element, handler) {
        var self = this;
        $(element).removeClass('js-hidden');
        self.currentContainer = element;
        self.currentButton = handler;
    },
    hide: function(element, handler) {
        var self = this;
        $(element).addClass('js-hidden');
        $(handler).parent().removeClass(self.constants.activeContainerClass);
    },
    hideComments: function(element, handler) {
        var self = this;
        $(element).addClass('js-hidden');
        $(handler).parent().removeClass(self.constants.activeCommentsContainerClass);
    },
    showComments: function(element, handler) {
        var self = this;
        $(element).removeClass('js-hidden');
        self.currentCommentsContainer = element;
        self.currentCommentsButton = handler;
    },
    loadRecipes: function () {
        var self = this;
        self.recipesPage++;
        $.ajax({
            url: Front.routes.get_recipes + '?page=' + self.recipesPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.recipesList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadRecipesButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_recipes_error, 'error');
            },
            cache: true
        });
    },
    loadArticles: function () {
        var self = this;
        self.articlesPage++;
        $.ajax({
            url: Front.routes.get_articles + '?page=' + self.articlesPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.articlesList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadArticlesButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_articles_error, 'error');
            },
            cache: true
        });
    },
    loadVideos: function () {
        var self = this;
        self.videosPage++;
        $.ajax({
            url: Front.routes.get_videos + '?page=' + self.videosPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.videosList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadVideosButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_videos_error, 'error');
            },
            cache: true
        });
    },
    loadRecipeQuestions: function () {
        var self = this;
        self.recipeQuestionsPage++;
        $.ajax({
            url: Front.routes.get_recipe_questions + '?page=' + self.recipeQuestionsPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.recipeQuestionsList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadRecipeQuestionsButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_recipe_questions_error, 'error');
            },
            cache: true
        });
    },
    loadRecipeReviews: function () {
        var self = this;
        self.recipeReviewsPage++;
        $.ajax({
            url: Front.routes.get_recipe_reviews + '?page=' + self.recipeReviewsPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.recipeReviewsList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadRecipeReviewsButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_recipe_reviews_error, 'error');
            },
            cache: true
        });
    },
    loadCommunityQuestions: function () {
        var self = this;
        self.communityQuestionsPage++;
        $.ajax({
            url: Front.routes.get_community_questions + '?page=' + self.communityQuestionsPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.communityQuestionsList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadCommunityQuestionsButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_community_questions_error, 'error');
            },
            cache: true
        });
    },
    loadArticleComments: function () {
        var self = this;
        self.articleCommentsPage++;
        $.ajax({
            url: Front.routes.get_article_comments + '?page=' + self.articleCommentsPage,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'get',
            success: function (res) {
                $(self.selectors.articleCommentsList).append(res.content);
                if (!res.hasMorePages) {
                    $(self.selectors.loadArticleCommentsButton).remove();
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.load_article_comments_error, 'error');
            },
            cache: true
        });
    }
};

$(document).ready(function () {
    Profile.init();
});