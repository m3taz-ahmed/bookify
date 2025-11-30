                
                <div class="space-y-4">
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">{{ __('website.otp_code') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="otp" name="otp" type="text" maxlength="6" required class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('otp') border-red-500 @enderror transition duration-200" placeholder="{{ __('website.enter_6_digit_code') }}" autocomplete="one-time-code">
                        </div>
                        @error('otp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5">
                        {{ __('website.verify_and_login') }}
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('website.didnt_receive_code') }}
                    <a href="{{ route('customer.login') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors duration-200">{{ __('website.resend_otp') }}</a>
                </p>
            </div>
        </div>
        
        <div class="text-center text-sm text-gray-500 mt-4">
            <p>&copy; {{ date('Y') }} Bookify. {{ __('website.all_rights_reserved') }}</p>
        </div>
    </div>
</div>
@endsection