<?php

declare(strict_types=1);

namespace App\Enums;

enum RouteNameEnum: string
{
    // Auth
    case AuthConfirmPasswordShow = 'auth.confirm-password.show';
    case AuthConfirmPasswordStore = 'auth.confirm-password.store';
    case AuthForgotPasswordCreate = 'forgot-password';
    case AuthLoginCreate = 'login';
    case AuthLoginStore = 'login.store';
    case AuthLogout = 'logout';
    case AuthResetPasswordCreate = 'auth.reset-password.create';
    case AuthResetPasswordStore = 'auth.reset-password.store';
    case AuthResetPassword = 'auth.password.update';
    case SignupCreate = 'signup';
    case SignupThanks = 'signup.thanks';
    case SignupWizard = 'signup.wizard';
    case AuthVerifyEmail = 'auth.verify-email';

    case AboutMetaFilter = 'about.metafilter';

    case AskPopularFavoritesIndex = 'ask.popular-favorites.index';
    case AskPopularPostIndex = 'ask.post.popular.index';
    case AskRandomPostShow = 'ask.random.show';

    case AskPostIndex = 'ask.post.index';
    case AskPostShow = 'ask.post.show';
    case AskPostCreate = 'ask.post.create';
    case AskPostStore = 'ask.post.store';
    case AskPostEdit = 'ask.post.edit';
    case AskPostUpdate = 'ask.post.update';
    case AskPostDelete = 'ask.post.delete';

    case BestOfHomeIndex = 'bestof.home.index';
    case BestOfPostShow = 'bestof.post.show';

    case ChatHomeIndex = 'chat.home.index';

    case CommentStore = 'comment.store';
    case CommentEdit = 'comment.edit';
    case CommentUpdate = 'comment.update';
    case CommentDelete = 'comment.delete';

    case ContactMessageCreate = 'contact.create';
    case ContactMessageStore = 'contact.store';

    case ContactsIndex = 'contacts.index';

    case FanFarePopularFavoritesIndex = 'fanfare.popular-favorites.index';
    case FanfarePostIndex = 'fanfare.post.index';
    case FanFarePostShow = 'fanfare.post.show';
    case FanFarePostCreate = 'fanfare.post.create';
    case FanFarePostStore = 'fanfare.post.store';
    case FanFarePostEdit = 'fanfare.post.edit';
    case FanFarePostUpdate = 'fanfare.post.update';
    case FanFarePostDelete = 'fanfare.post.delete';

    case FaqIndex = 'faq.index';

    case FavoritesIndex = 'favorites.index';

    case IdeasIndex = 'ideas.index';

    case MetaFilterFundingIndex = 'metafilter.funding.index';

    case IrlPostIndex = 'irl.post.index';
    case IrlPostShow = 'irl.post.show';
    case IrlPostCreate = 'irl.post.create';
    case IrlPostStore = 'irl.post.store';
    case IrlPostEdit = 'irl.post.edit';
    case IrlPostUpdate = 'irl.post.update';
    case IrlPostDelete = 'irl.post.delete';

    case JobsPostIndex = 'jobs.post.index';
    case JobsPostShow = 'jobs.post.show';
    case JobsPostJobCreate = 'jobs.post-job.create';
    case JobsPostAvailabilityCreate = 'jobs.post-availability.create';
    case JobsPostStore = 'jobs.post.store';
    case JobsPostEdit = 'jobs.post.edit';
    case JobsPostUpdate = 'jobs.post.update';
    case JobsPostDelete = 'jobs.post.delete';

    case LabsHomeIndex = 'labs.home.index';

    case LanguageSwitcher = 'language';

    case MailIndex = 'metafilter.mail.index';
    case MailHomeIndex = 'mail.home.index';

    case MallHomeIndex = 'mall.home.index';

    case MetaFilterArchivesIndex = 'metafilter.archives.index';
    case MetaFilterCommentIndex = 'metafilter.comment.index';
    case MetaFilterPostIndex = 'metafilter.post.index';
    case MetaFilterPopularPostIndex = 'metafilter.post.popular.index';
    case MetaFilterPopularFavoritesIndex = 'metafilter.popular-favorites.index';
    case MetaFilterRandomPostShow = 'metafilter.random.show';
    case MetaFilterRecentActivityShow = 'metafilter.recent-activity.show';
    case MetaFilterPostShow = 'metafilter.post.show';
    case MetaFilterPostCreate = 'metafilter.post.create';
    case MetaFilterPostStore = 'metafilter.post.store';
    case MetaFilterPostEdit = 'metafilter.post.edit';
    case MetaFilterPostUpdate = 'metafilter.post.update';
    case MetaFilterPostDelete = 'metafilter.post.delete';

    case MetaTalkPopularPostIndex = 'metatalk.post.popular.index';
    case MetaTalkPopularFavoritesIndex = 'metatalk.popular-favorites.index';
    case MetaTalkPostIndex = 'metatalk.post.index';
    case MetaTalkPostShow = 'metatalk.post.show';
    case MetaTalkPostCreate = 'metatalk.post.create';
    case MetaTalkPostStore = 'metatalk.post.store';
    case MetaTalkPostEdit = 'metatalk.post.edit';
    case MetaTalkPostUpdate = 'metatalk.post.update';
    case MetaTalkPostDelete = 'metatalk.post.delete';

    case MusicPopularPostIndex = 'music.post.popular.index';
    case MusicPopularFavoritesIndex = 'music.popular-favorites.index';
    case MusicPostIndex = 'music.post.index';
    case MusicPostShow = 'music.post.show';
    case MusicPostSongCreate = 'music.post-song.create';
    case MusicPostTalkCreate = 'music.post-talk.create';
    case MusicPostStore = 'music.post.store';
    case MusicPostEdit = 'music.post.edit';
    case MusicPostUpdate = 'music.post.update';
    case MusicPostDelete = 'music.post.delete';

    case MyMeFiComments = 'metafilter.my.comments';
    case MyMeFiFavorites = 'metafilter.my.favorites';
    case MyMeFiIndex = 'metafilter.my.index';

    case PodcastPostIndex = 'podcast.post.index';
    case PodcastPostShow = 'podcast.post.show';
    case PodcastPostCreate = 'podcast.post.create';
    case PodcastPostStore = 'podcast.post.store';
    case PodcastPostEdit = 'podcast.post.edit';
    case PodcastPostUpdate = 'podcast.post.update';
    case PodcastPostDelete = 'podcast.post.delete';

    case PreferencesEdit = 'preferences.edit';

    case ProfileIndex = 'members.index';
    case ProfileShow = 'members.show';
    case ProfileCreate = 'members.create';
    case ProfileStore = 'members.store';
    case ProfileEdit = 'members.edit';
    case ProfileUpdate = 'members.update';
    case ProfileDelete = 'members.delete';

    case ProjectsPopularPostIndex = 'projects.post.popular.index';
    case ProjectsPostIndex = 'projects.post.index';
    case ProjectsPostShow = 'projects.post.show';
    case ProjectsPostCreate = 'projects.post.create';
    case ProjectsPostStore = 'projects.post.store';
    case ProjectsPostEdit = 'projects.post.edit';
    case ProjectsPostUpdate = 'projects.post.update';
    case ProjectsPostDelete = 'projects.post.delete';

    case SearchCreate = 'search.create';
    case SearchShow = 'search.show';

    case TagsIndex = 'metafilter.tags.index';
}
